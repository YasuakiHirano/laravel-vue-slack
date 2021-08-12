<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChannelUser;
use App\Models\User;
use Illuminate\Http\Request;
use \Symfony\Component\HttpFoundation\Response;

class ChannelUserController extends Controller
{
    /**
     * チャンネルに関連するユーザーを作成する
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request) {
        $request->validate([
            'channel_id' => 'required',
            'user_ids' => 'required',
        ]);

        foreach ($request->user_ids as $userId) {
            ChannelUser::create([
                'channel_id' => $request->channel_id,
                'user_id' => $userId,
            ]);
        }

        return response()->json('ChannelUser created completed.', Response::HTTP_OK);
    }

    /**
     * チャンネルIDに関連するユーザー一覧取得
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetch(Request $request) {
        $request->validate([
            'channel_id' => 'required'
        ]);

        $channelUsers = (new ChannelUser())->fetchChannelUsers($request->channel_id);

        return response()->json($channelUsers, Response::HTTP_OK);
    }

    /**
     * チャンネルIDに関連しないユーザー一覧取得
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchNotChannelUsers(Request $request) {
        $request->validate([
            'channel_id' => 'required'
        ]);

        $users = (new User())->fetchNotChannelUsers($request->channel_id);

        return response()->json($users, Response::HTTP_OK);
    }
}
