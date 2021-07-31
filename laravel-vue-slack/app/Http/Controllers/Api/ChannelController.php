<?php

namespace App\Http\Controllers\Api;

use App\Events\ChannelEvent;
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

        broadcast(new ChannelEvent('create-channel', $channel));
        return response()->json('Channel registration completed.', Response::HTTP_OK);
    }

    public function fetch() {
        $userId = Auth::id();
        $channelUsers = ChannelUser::whereUserId($userId)->get();

        $channelIds = $channelUsers->pluck('channel_id');
        $channels = (new Channel())->fetchChannelList($channelIds);

        return response()->json($channels, Response::HTTP_OK);
    }

    public function update(Request $request) {
        $request->validate([
            'id' => 'required'
        ]);

        $channel = Channel::find($request->id);

        $name = isset($request->name) ? $request->name : $channel->name;
        $description = isset($request->description) ? $request->description : $channel->description;
        $isPublic = isset($request->is_public) ? $request->is_public : $channel->is_public;

        $channel->update([
            'name' => $name,
            'description' => $description,
            'is_public' => $isPublic,
        ]);

        broadcast(new ChannelEvent('update-channel', $channel));
        return response()->json('Channel update completed.', Response::HTTP_OK);
    }

    public function countChannelUser(Request $request) {
        $count = ChannelUser::whereChannelId($request->channel_id)->count();
        return response()->json($count, Response::HTTP_OK);
    }
}
