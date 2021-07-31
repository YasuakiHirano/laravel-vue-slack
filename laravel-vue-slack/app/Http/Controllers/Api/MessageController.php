<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Events\MessageEvent;
use Illuminate\Support\Facades\Auth;
use \Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function create(Request $request) {
        $request->validate([
            'channel_id' => 'required',
            'content' => 'required',
        ]);

        $message = Message::create([
            'user_id' => Auth::id(),
            'channel_id' => $request->channel_id,
            'content' => $request->content
        ]);

        $messageModel = new Message();
        $messageQuery = $messageModel->createMessageQuery($request->channel_id);

        $selectMessage = $messageQuery
                            ->where('messages.id', '=', $message->id)
                            ->first();

        if ($messageModel->countTodayMessage() != 0) {
            if (isset($selectMessage->date)) {
                $selectMessage->date = '';
            }
        }

        broadcast(new MessageEvent('create-message', $selectMessage->toArray(), null));
        return response()->json('Message registration completed.', Response::HTTP_OK);
    }

    public function fetch(Request $request) {
        $messageQuery = (new Message())->createMessageQuery($request->channel_id);

        $messages = $messageQuery
                        ->orderBy('messages.created_at')
                        ->get();

        // 同じ日付のメッセージだった場合は日付を空にする
        $beforeDate = '';
        foreach ($messages as $key => $message) {
            if ($beforeDate != $message->date) {
                $beforeDate = $message->date;
            } else {
                $messages[$key]->date = '';
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
