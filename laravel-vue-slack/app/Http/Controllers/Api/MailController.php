<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Lang;
use App\Http\Controllers\Controller;
use \Symfony\Component\HttpFoundation\Response;


class MailController extends Controller
{
    public function sendInvitation() {
      // TODO: メール送信
      logger()->info(Lang::get('message.mail.invitation', ['url' => 'https://google.com']));

      return  response()->json('Success: Send Invitation Mail', Response::HTTP_OK);
    }
}
