<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Message;
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

        Message::create([
            'user_id' => Auth::id(),
            'channel_id' => $request->channel_id,
            'content' => $request->content
        ]);

        return response()->json('Message registration completed.', Response::HTTP_OK);
    }

    public function fetch(Request $request) {
        $messages = Message::select([
               'messages.id',
               DB::raw("DATE_FORMAT(messages.created_at, '%Y年%m月%d日') as date"),
               DB::raw("CONCAT('image/user_image_', user_information.image_number, '.png') as imagePath"),
               "users.name as postUserName",
               DB::raw("DATE_FORMAT(messages.created_at, '%H:%i') as postTime"),
               "messages.content"
           ])
          ->from('messages')
          ->join('users', function($join) {
              $join->on('users.id', '=', 'messages.user_id');
          })
          ->join('user_information', function($join) {
              $join->on('users.id', '=', 'user_information.user_id');
          })
          ->orderBy('messages.created_at')
          ->with('reactions')
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
