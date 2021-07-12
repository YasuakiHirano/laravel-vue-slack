<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use \Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{
    public function create(Request $request) {
        $request->validate([
            'channel_id' => 'required',
            'content' => 'required',
        ]);

        Message::create([
            'user_id' => Auth::id(),
            'channel_id' => $request->channel_id,
            'content' => $request->content
        ]);

        return response()->json('Message registration completed.', Response::HTTP_OK);
    }

    public function fetch(Request $request) {
        // TODO: 返すデータの修正
        $messages = Message::whereUserId(Auth::id())
                ->whereChannelId($request->channel_id)
                ->with('reactions')
                ->get();

        return  response()->json($messages, Response::HTTP_OK);
    }
}
