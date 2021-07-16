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

        $messageQuery = (new Message())->createMessageQuery();

        $selectMessage = $messageQuery
                            ->where('messages.id', '=', $message->id)
                            ->first();

        broadcast(new MessageEvent('general-channel', $selectMessage->toArray()));
        return response()->json('Message registration completed.', Response::HTTP_OK);
    }

    public function fetch() {
        $messageQuery = (new Message())->createMessageQuery();

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
}
