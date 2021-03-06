<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Models\ChannelUser;
use App\Models\UserInformation;
use \Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * ユーザーを作成する
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateUserRequest $request) {
        $userInformation = UserInformation::whereSendEmail($request->email)->first();
        if (is_null($userInformation)) {
            return response()->json('Not found user entry data.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // ユーザー作成
        $user = User::create([
            'name' =>  $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // デフォルトのチャンネルを追加する
        ChannelUser::create([
            'user_id' => $user->id,
            'channel_id' => config('const.default_channel_id')
        ]);

        // ユーザーステータス更新
        UserInformation::whereSendEmail($request->email)->update([
            'user_id' => $user->id,
            'status' => config('const.user_status.registered')
        ]);

        // サインイン処理
        Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);

        return response()->json('User registration completed.', Response::HTTP_OK);
    }

    /**
     * サインインしているユーザーを返す
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function find () {
        $user = Auth::user();
        return response()->json($user, Response::HTTP_OK);
    }
}
