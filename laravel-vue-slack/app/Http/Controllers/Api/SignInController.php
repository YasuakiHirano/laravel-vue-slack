<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use App\Http\Controllers\Controller;
use \Symfony\Component\HttpFoundation\Response;


class SignInController extends Controller
{
    /**
     * ユーザーのサインイン処理
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signIn(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            return response()->json('OK.', Response::HTTP_OK);
        }

        return response()->json(Lang::get('message.user_not_found'), Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
