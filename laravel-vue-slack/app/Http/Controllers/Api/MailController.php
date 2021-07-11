<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Lang;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserInformation;
use \Symfony\Component\HttpFoundation\Response;
use SendGrid;
use SendGrid\Mail\Mail;

class MailController extends Controller
{
    /** @var int $randomImageMin ログイン時の画像をランダム決定用(最小値) */
    private $randomImageMin = 1;

    /** @var int $randomImageMax ログイン時の画像をランダム決定用(最大値) */
    private $randomImageMax = 7;

    public function sendInvitation(Request $request) {
        $request->validate([
            'email' => 'required'
        ]);

        $imageNumber = mt_rand($this->randomImageMin, $this->randomImageMax);
        $userInformation = UserInformation::create([
            'image_number' => $imageNumber,
            'send_email' => $request->email,
            'status' => config('const.user_status.unregisterd'),
        ]);

        $param = encrypt($userInformation->id);
        $callbackUrl = url('/') . '/mail/invitation/callback?param='.$param;

        // メール送信
        $mailContents = Lang::get('message.mail.invitation.content', ['url' => $callbackUrl]);
        logger()->info($mailContents);

        $email = new Mail();
        $email->setFrom(env('MAIL_FROM_ADDRESS'), env("APP_NAME"));
        $email->setSubject(Lang::get('message.mail.invitation.title'));
        $email->addTo($request->email);
        $email->addContent("text/plain", $mailContents);

        $sendgrid = new SendGrid(env('SENDGRID_API_KEY'));

        $response = $sendgrid->send($email);
        if ($response->statusCode() == Response::HTTP_ACCEPTED) {
            // ユーザーステータス更新
            UserInformation::whereSendEmail($request->email)->update(['status' => config('const.user_status.registerd')]);

            return  response()->json('Success: Send Invitation Mail', Response::HTTP_OK);
        } else {
            return  response()->json('Faild: Send Invitation Mail', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
