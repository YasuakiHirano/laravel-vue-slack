<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\UserInformation;
use \Symfony\Component\HttpFoundation\Response;;

class UserController extends Controller
{
    public function create(Request $request) {
        /** @var Illuminate\Validation\Validator $validator */
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);

        $userInformation = UserInformation::whereSendEmail($request->email)->first();
        if (is_null($userInformation)) {
            return response()->json('Not found user entry data.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // ユーザー作成
        User::create([
            'name' =>  $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // ログイン処理
        Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);

        return response()->json('User registration completed.', Response::HTTP_OK);
    }

    public function find () {
        $user = Auth::user();
        return response()->json($user, Response::HTTP_OK);
    }
}
