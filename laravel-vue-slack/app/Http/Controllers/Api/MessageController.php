<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Thread;
use App\Events\MessageEvent;
use App\Events\MentionEvent;
use App\Http\Requests\MessageRequests\CreateMessageRequest;
use App\Http\Requests\MessageRequests\DeleteMessageRequest;
use App\Http\Requests\MessageRequests\FetchMessageRequest;
use App\Http\Requests\MessageRequests\UpdateMessageRequest;
use App\Models\Mention;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use \Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{
    /**
     * メッセージを作成する
     *
     * @param CreateMessageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateMessageRequest $request) {
        // メッセージを作成する
        $isThreadMessage = isset($request->parent_message_id) ? true : false;
        $message = Message::create([
            'user_id' => Auth::id(),
            'channel_id' => $request->channel_id,
            'content' => $request->content,
            'is_thread_message' => $isThreadMessage
        ]);

        // メッセージに付加しているメンションを作成する
        $createMentions = [];
        $allUsers = User::select(['id', 'name'])->get()->pluck('name', 'id');
        if (isset($request->mention_users)) {
            $users = User::whereIn('name', $request->mention_users)->get();

            foreach ($users as $user) {
                $createMention = Mention::create([
                    'message_id' => $message->id,
                    'user_id' => $user->id,
                    'create_user_id' => isset($request->create_user_id) ? $request->create_user_id : 0,
                ]);

                $createMention->user_name = $allUsers[$createMention->user_id];
                array_push($createMentions, $createMention);
            }
        }

        $messageModel = new Message();
        if ($isThreadMessage) {
            // スレッドの場合は、スレッドのメッセージとして関連付ける
            Thread::create([
                'message_id' => $message->id,
                'parent_message_id' => $request->parent_message_id,
            ]);

            $messageQuery = $messageModel->createMessageQuery(null, [$message->id]);
            $selectMessage = $messageQuery->first();
        } else {
            $messageQuery = $messageModel->createMessageQuery($request->channel_id);
            $selectMessage = $messageQuery
                                ->where('messages.id', '=', $message->id)
                                ->first();
        }

        // メンションをブロードキャストで送信する
        foreach ($createMentions as $key => $mention) {
            $selectMessage->mentions[$key] = $mention;
            broadcast(new MentionEvent('create-mention', $request->content, $mention->user_id, $selectMessage->imagePath));
        }

        // 同じ日のデータが既にあったら日付を空にする
        if ($messageModel->countTodayMessage() != 0) {
            if (isset($selectMessage->date)) {
                $selectMessage->date = '';
            }
        }

        // 作成したメッセージをブロードキャストで送信する
        broadcast(new MessageEvent('create-message', $request->channel_id, $selectMessage->toArray(), null, $message->is_thread_message));

        return response()->json('Message registration completed.', Response::HTTP_OK);
    }

    /**
     * メッセージ一覧を取得する
     *
     * @param FetchMessageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetch(FetchMessageRequest $request) {
        $messageQuery = (new Message())->createMessageQuery($request->channel_id);

        $messages = $messageQuery
                        ->orderBy('messages.created_at')
                        ->get();

        $messages = $this->editMessageProperty($messages);

        return  response()->json($messages, Response::HTTP_OK);
    }

    /**
     * スレッドのメッセージ一覧を取得する
     *
     * @param int $parentMessageId
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchThreadMessage($parentMessageId) {
        if (empty($parentMessageId)) {
            return response()->json(Lang::get('message.message.parent_message_id_empty'), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $threads = Thread::whereParentMessageId($parentMessageId)->get();

        $messageQuery = (new Message())->createMessageQuery(null, $threads->pluck('message_id'));

        $messages = $messageQuery
        ->orderBy('messages.created_at')
        ->get();

        $messages = $this->editMessageProperty($messages);

        return  response()->json($messages, Response::HTTP_OK);
    }

    /**
     * 取得したメッセージを編集する
     *
     * @param Collection $messages
     * @return Collection
     */
    private function editMessageProperty($messages) {
        // 全ユーザーのIDをキーに名前の配列を作成する
        $users = User::select(['id', 'name'])->get()->pluck('name', 'id');

        $beforeDate = '';
        foreach ($messages as $key => $message) {
            // 同じ日付のメッセージだった場合は日付を空にする
            if ($beforeDate != $message->date) {
                $beforeDate = $message->date;
            } else {
                $messages[$key]->date = '';
            }

            // メンションのユーザー名を設定する
            foreach ($message->mentions as $mentionKey => $mention) {
                $messages[$key]->mentions[$mentionKey]->user_name = $users[$mention->user_id];
            }
        }
        return $messages;
    }

    /**
     * メッセージを更新する
     *
     * @param UpdateMessageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateMessageRequest $request) {
        $message = Message::find($request->message_id);
        $message->update([
            'content' => $request->content
        ]);

        broadcast(new MessageEvent('update-message', null, $request->content, $message->id, $message->is_thread_message));
        return response()->json('Message update completed.', Response::HTTP_OK);
    }

    /**
     * メッセージを削除する
     *
     * @param DeleteMessageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(DeleteMessageRequest $request) {
        $message = Message::find($request->message_id);
        if ($message->user_id !== Auth::id()) {
            return response()->json(Lang::get('message.message.other_user_post_delete'), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $message->delete();

        broadcast(new MessageEvent('delete-message', null, null, $message->id, $message->is_thread_message));
        return response()->json('Message delete completed.', Response::HTTP_OK);
    }
}
