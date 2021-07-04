<?php

use App\Http\Controllers\Api\MailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SignInController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::group(['middleware' => ['auth:sanctum']], function () {
    // ログインユーザー取得
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // 招待メール送信
    Route::post('/mail/invitation', [MailController::class, 'sendInvitation']);
});


// ユーザー登録
Route::post('/user', [UserController::class, 'create']);
Route::get('/user', [UserController::class, 'find']);

// サインイン
Route::post('/signin', [SignInController::class, 'signIn']);


Route::get('/404', function() {
    return response("404 NOT FOUND", 404);
})->name("not_found");
