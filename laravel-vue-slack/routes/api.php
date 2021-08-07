<?php

use App\Http\Controllers\Api\MailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SignInController;
use App\Http\Controllers\Api\ChannelController;
use App\Http\Controllers\Api\ChannelUserController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\ReactionController;

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
    Route::get('/users', [UserController::class, 'find']);

    // チャンネル
    Route::post('/channels', [ChannelController::class, 'create']);
    Route::get('/channels', [ChannelController::class, 'fetch']);
    Route::put('/channels', [ChannelController::class, 'update']);
    Route::get('/channels/user_count', [ChannelController::class, 'countChannelUser']);

    // チャンネルに関連するユーザー情報
    Route::post('/channel_users', [ChannelUserController::class, 'create']);
    Route::get('/channel_users', [ChannelUserController::class, 'fetch']);
    Route::get('/channel_users/not_channel_users', [ChannelUserController::class, 'fetchNotChannelUsers']);

    // メッセージ
    Route::post('/messages', [MessageController::class, 'create']);
    Route::get('/messages', [MessageController::class, 'fetch']);
    Route::get('/messages/{parent_message_id}', [MessageController::class, 'fetchThreadMessage']);
    Route::put('/messages', [MessageController::class, 'update']);
    Route::delete('/messages', [MessageController::class, 'delete']);

    // 招待メール送信
    Route::post('/mail/invitation', [MailController::class, 'sendInvitation']);

    // リアクション
    Route::post('/reaction', [ReactionController::class, 'updateOrCreate']);
    Route::get('/reaction/plus', [ReactionController::class, 'updateReactionNumber']);
});

// ユーザー登録
Route::post('/users', [UserController::class, 'create']);

// サインイン
Route::post('/signin', [SignInController::class, 'signIn']);


Route::get('/404', function() {
    return response("404 NOT FOUND", 404);
})->name("not_found");
