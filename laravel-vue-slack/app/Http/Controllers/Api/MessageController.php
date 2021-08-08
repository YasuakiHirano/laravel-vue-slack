<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Thread;
use App\Events\MessageEvent;
use App\Events\MentionEvent;
use App\Events\ThreadEvent;
use App\Models\Mention;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use \Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{
    public function create(Request $request) {
        $request->validate([
            'channel_id' => 'required',
            'content' => 'required',
        ]);

        $isThreadMessage = isset($request->parent_message_id) ? true : false;

        $message = Message::create([
            'user_id' => Auth::id(),
            'channel_id' => $request->channel_id,
            'content' => $request->content,
            'is_thread_message' => $isThreadMessage
        ]);

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

        if ($isThreadMessage) {
            Thread::create([
                'message_id' => $message->id,
                'parent_message_id' => $request->parent_message_id,
            ]);

            $messageModel = new Message();
            $messageQuery = $messageModel->createMessageQuery(null, [$message->id]);
            $threadMessage = $messageQuery->first();

            if ($messageModel->countTodayMessage() != 0) {
                if (isset($threadMessage->date)) {
                    $threadMessage->date = '';
                }
            }

            foreach ($createMentions as $key => $mention) {
                $threadMessage->mentions[$key] = $mention;
                broadcast(new MentionEvent('create-mention', $request->content, $mention->user_id, $threadMessage->imagePath));
            }

            broadcast(new ThreadEvent('create-thread', $threadMessage->toArray(), $request->parent_message_id));
        } else {
            $messageModel = new Message();
            $messageQuery = $messageModel->createMessageQuery($request->channel_id);

            $selectMessage = $messageQuery
                                ->where('messages.id', '=', $message->id)
                                ->first();

            foreach ($createMentions as $key => $mention) {
                $selectMessage->mentions[$key] = $mention;
                broadcast(new MentionEvent('create-mention', $request->content, $mention->user_id, $selectMessage->imagePath));
            }

            if ($messageModel->countTodayMessage() != 0) {
                if (isset($selectMessage->date)) {
                    $selectMessage->date = '';
                }
            }

            broadcast(new MessageEvent('create-message', $selectMessage->toArray(), null));
        }

        return response()->json('Message registration completed.', Response::HTTP_OK);
    }

    public function fetch(Request $request) {
        $messageQuery = (new Message())->createMessageQuery($request->channel_id);

        $messages = $messageQuery
                        ->orderBy('messages.created_at')
                        ->get();

        $users = User::select(['id', 'name'])->get()->pluck('name', 'id');

        // 同じ日付のメッセージだった場合は日付を空にする
        $beforeDate = '';
        foreach ($messages as $key => $message) {
            if ($beforeDate != $message->date) {
                $beforeDate = $message->date;
            } else {
                $messages[$key]->date = '';
            }

            foreach ($message->mentions as $mentionKey => $mention) {
                $messages[$key]->mentions[$mentionKey]->user_name = $users[$mention->user_id];
            }
        }

        return  response()->json($messages, Response::HTTP_OK);
    }

    public function fetchThreadMessage($parentMessageId) {
        $threads = Thread::whereParentMessageId($parentMessageId)->get();

        $messageQuery = (new Message())->createMessageQuery(null, $threads->pluck('message_id'));

        $messages = $messageQuery
        ->orderBy('messages.created_at')
        ->get();

        $users = User::select(['id', 'name'])->get()->pluck('name', 'id');

        // 同じ日付のメッセージだった場合は日付を空にする
        $beforeDate = '';
        foreach ($messages as $key => $message) {
            if ($beforeDate != $message->date) {
                $beforeDate = $message->date;
            } else {
                $messages[$key]->date = '';
            }

            foreach ($message->mentions as $mentionKey => $mention) {
                $messages[$key]->mentions[$mentionKey]->user_name = $users[$mention->user_id];
            }
        }

        return  response()->json($messages, Response::HTTP_OK);
    }

    public function update(Request $request) {
        $request->validate([
            'message_id' => 'required',
            'content' => 'required',
            'channel_id' => 'required',
        ]);

        $message = Message::find($request->message_id);
        $message->update([
            'content' => $request->content
        ]);

        broadcast(new MessageEvent('update-message', $request->content, $message->id));
        return response()->json('Message update completed.', Response::HTTP_OK);
    }

    public function delete(Request $request) {
        $request->validate([
            'message_id' => 'required',
            'channel_id' => 'required',
        ]);

        $message = Message::find($request->message_id);
        if ($message->user_id !== Auth::id()) {
            return response()->json(['error' => '他のユーザーの投稿は削除できません。'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $message->delete();

        broadcast(new MessageEvent('delete-message', null, $message->id));
        return response()->json('Message delete completed.', Response::HTTP_OK);
    }
}
