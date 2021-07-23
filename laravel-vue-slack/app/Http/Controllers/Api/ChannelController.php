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
    public function create(Request $request) {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'is_private' => 'required',
        ]);

        $userId = Auth::id();

        $channel = Channel::create([
            'name' => $request->name,
            'description' => $request->description,
            'make_user_id' => $userId,
            'is_public' => $request->is_private ? false : true,
        ]);

        ChannelUser::create([
            'user_id' => $userId,
            'channel_id' => $channel->id
        ]);

        return response()->json('Channel registration completed.', Response::HTTP_OK);
    }

    public function fetch() {
        $userId = Auth::id();
        $channelUsers = ChannelUser::whereUserId($userId)->get();

        $channelIds = $channelUsers->pluck('channel_id');
        $channels = (new Channel())->fetchChannelList($channelIds);

        return response()->json($channels, Response::HTTP_OK);
    }

    public function countChannelUser(Request $request) {
        $count = ChannelUser::whereChannelId($request->channel_id)->count();
        return response()->json($count, Response::HTTP_OK);
    }
}
