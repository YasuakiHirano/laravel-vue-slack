<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignInRequest;
use \Symfony\Component\HttpFoundation\Response;


class SignInController extends Controller
{
    /**
     * ユーザーのサインイン処理
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signIn(SignInRequest $request) {
        if (Auth::attempt($request->all())) {
            return response()->json('OK.', Response::HTTP_OK);
        }

        return response()->json(Lang::get('message.user_not_found'), Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
