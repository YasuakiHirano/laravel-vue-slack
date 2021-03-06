<?php

namespace App\Http\Controllers\Api;

use App\Events\ChannelEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChannelRequests\CountChannelRequest;
use App\Http\Requests\ChannelRequests\CreateChannelRequest;
use App\Http\Requests\ChannelRequests\DeleteChannelRequest;
use App\Http\Requests\ChannelRequests\UpdateChannelRequest;
use App\Models\Channel;
use App\Models\ChannelUser;
use Illuminate\Support\Facades\Auth;
use \Symfony\Component\HttpFoundation\Response;

class ChannelController extends Controller
{
    /**
     * チャンネルを作成する
     *
     * @param CreateChannelRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateChannelRequest $request) {
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

        /** @var Collection|null */
        $fetchChannel = (new Channel())->fetchChannelList([$channel->id]);
        broadcast(new ChannelEvent('create-channel', $fetchChannel->toArray(), $userId));
        return response()->json('Channel registration completed.', Response::HTTP_OK);
    }

    /**
     * サインインユーザーに関連するチャンネル一覧取得
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetch() {
        $userId = Auth::id();
        $channelUsers = ChannelUser::whereUserId($userId)->get();

        $channelIds = $channelUsers->pluck('channel_id');
        $channels = (new Channel())->fetchChannelList($channelIds);

        return response()->json($channels, Response::HTTP_OK);
    }

    /**
     * チャンネル(名前・説明・公開/非公開)を更新する
     *
     * @param UpdateChannelRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateChannelRequest $request) {
        /** @var Channel|null */
        $channel = Channel::find($request->id);

        $name = isset($request->name) ? $request->name : $channel->name;
        $description = isset($request->description) ? $request->description : $channel->description;
        $isPublic = isset($request->is_public) ? $request->is_public : $channel->is_public;

        $channel->update([
            'name' => $name,
            'description' => $description,
            'is_public' => $isPublic,
        ]);

        broadcast(new ChannelEvent('update-channel', $channel, null));
        return response()->json('Channel update completed.', Response::HTTP_OK);
    }

    /**
     * チャンネルを削除する
     *
     * @param DeleteChannelRequest $request
     * @return void
     */
    public function delete(DeleteChannelRequest $request) {
        $channel = Channel::find($request->channel_id);
        $channel->delete();

        broadcast(new ChannelEvent('delete-channel', $channel, null));
        return response()->json('Channel update completed.', Response::HTTP_OK);
    }

    /**
     * チャンネルに関連するユーザーの数を取得する
     *
     * @param CountChannelRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function countChannelUser(CountChannelRequest $request) {
        $count = ChannelUser::whereChannelId($request->channel_id)->count();
        return response()->json($count, Response::HTTP_OK);
    }
}
