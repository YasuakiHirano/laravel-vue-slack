<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChannelUser;
use App\Models\User;
use App\Models\Channel;
use App\Events\ChannelUserEvent;
use App\Http\Requests\ChannelUserRequests\CreateChannelUserRequest;
use App\Http\Requests\ChannelUserRequests\FetchChannelUserRequest;
use \Symfony\Component\HttpFoundation\Response;

class ChannelUserController extends Controller
{
    /**
     * チャンネルに関連するユーザーを作成する
     *
     * @param CreateChannelUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateChannelUserRequest $request) {
        foreach ($request->user_ids as $userId) {
            ChannelUser::create([
                'channel_id' => $request->channel_id,
                'user_id' => $userId,
            ]);
        }

        /** @var Collection|null */
        $channelUsers = (new ChannelUser())->fetchChannelUsers($request->channel_id);
        if ($channelUsers) {
          /** @var Collection|null */
          $channelObject = (new Channel())->fetchChannelList([$request->channel_id]);
          broadcast(new ChannelUserEvent('create-channel-user', $request->channel_id, $channelUsers->toArray(), $channelObject->toArray()));
        }

        return response()->json('ChannelUser created completed.', Response::HTTP_OK);
    }

    /**
     * チャンネルIDに関連するユーザー一覧取得
     *
     * @param FetchChannelUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetch(FetchChannelUserRequest $request) {
        $channelUsers = (new ChannelUser())->fetchChannelUsers($request->channel_id);

        return response()->json($channelUsers, Response::HTTP_OK);
    }

    /**
     * チャンネルIDに関連しないユーザー一覧取得
     *
     * @param FetchChannelUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchNotChannelUsers(FetchChannelUserRequest $request) {
        $users = (new User())->fetchNotChannelUsers($request->channel_id);

        return response()->json($users, Response::HTTP_OK);
    }
}
