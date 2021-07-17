<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use App\Models\ChannelUser;
use Illuminate\Support\Facades\Auth;
use \Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    public function fetch() {
        $userId = Auth::id();
        $channelUsers = ChannelUser::whereUserId($userId)->get();

        $channelIds = $channelUsers->pluck('channel_id');
        $channels = Channel::whereIn('id', $channelIds)->get();

        return response()->json($channels, Response::HTTP_OK);
    }

    public function countChannelUser(Request $request) {
        $count = ChannelUser::whereChannelId($request->channel_id)->count();
        return response()->json($count, Response::HTTP_OK);
    }
}
