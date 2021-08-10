<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserInformation;
use Exception;

class MailController extends Controller
{
    /**
     * 招待メールからアカウント作成画面を表示する
     *
     * @param Request $request
     * @return Illuminate\View\View
     */
    public function invitationCallback(Request $request) {
        try {
            $userInformationId = decrypt($request->param);
            $userInformation = UserInformation::find($userInformationId);

            if ($userInformation == null) {
                throw new Exception("User not found.");
            }

            return view('account_create', [
                'sendEmail' => $userInformation->send_email,
                'userInformationId' => encrypt($userInformation->id),
            ]);
        } catch (\Throwable $e){
            logger()->error($e);
            return view('404');
        }

    }
}
