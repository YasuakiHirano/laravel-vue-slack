<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Lang;
use App\Http\Controllers\Controller;
use App\Models\UserInformation as ModelsUserInformation;
use Illuminate\Http\Request;
use App\Models\UserInformation;
use \Symfony\Component\HttpFoundation\Response;


class MailController extends Controller
{
    public function sendInvitation(Request $request) {
        $request->validate([
            'email' => 'required'
        ]);

        $imageNumber = mt_rand(1, 7);
        $userInformation = UserInformation::create([
            'image_number' => $imageNumber,
            'send_email' => $request->email,
            'status' => '0',
        ]);

        $param = encrypt($userInformation->id);
        $callbackUrl = url('/') . '/mail/invitation/callback?param='.$param;

        // TODO: メール送信
        logger()->info(Lang::get('message.mail.invitation', ['url' => $callbackUrl]));

        return  response()->json('Success: Send Invitation Mail', Response::HTTP_OK);
    }
}
