<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChannelUser;
use Illuminate\Http\Request;
use \Symfony\Component\HttpFoundation\Response;

class ChannelUserController extends Controller
{
    public function fetch(Request $request) {
        $request->validate([
            'channel_id' => 'required'
        ]);

        $channelUsers = (new ChannelUser())->fetchChannelUsers($request->channel_id);

        return response()->json($channelUsers, Response::HTTP_OK);
    }
}
