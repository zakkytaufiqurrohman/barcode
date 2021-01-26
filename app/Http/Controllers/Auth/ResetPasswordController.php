<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Mail\SendResetPasswordMail;
use Illuminate\Support\Facades\Mail;

class ResetPasswordController extends Controller
{
    //
    public function index()
    {
        return view('auth.resetpassword');
    }

    public function sendLinkReset(Request $request)
    {
        $email = $request->get('email');

        Mail::to($email)->send(new SendResetPasswordMail());
    }
}
