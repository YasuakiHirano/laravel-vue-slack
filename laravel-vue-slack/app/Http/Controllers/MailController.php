<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserInformation;
use Exception;

class MailController extends Controller
{
    public function invitationCallback(Request $request) {
        try {
            $userInformationId = decrypt($request->param);
            $userInformation = UserInformation::find($userInformationId);

            if ($userInformation == null) {
                throw new Exception("User not found.");
            }

            return view('account_create', ['sendEmail' => $userInformation->send_email]);
        } catch (\Throwable $e){
            logger()->info($e);

            return view('404');
        }

    }
}
