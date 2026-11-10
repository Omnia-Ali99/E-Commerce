<?php

namespace App\Http\Controllers\Api\User\Auth\Password;

use App\Models\User;
use Ichtrojan\Otp\Otp;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\SendOtpNotify;

class PasswordController extends Controller
{
    use ApiResponse;

    protected $otp2;
    public function __construct()
    {
        $this->otp2  = new Otp;
    }
    public function forgotPassword(Request $request)
    {
        $user = User::where('email', $request->username)
            ->orWhere('phone', $request->username)->first();

        if (!$user) {
            return $this->apiResponse(null,null, __('website.user_not_found'), 404);
        }

        $user->notify(new SendOtpNotify());
        return $this->apiResponse(null,null, __('website.otp_sent_successfully'), 200);
    }

    public function resetPassword(Request $request)
    {
        if (!$this->otp2->validate($request->email, $request->otp)) {
            return $this->apiResponse(null,null, __('website.invalid_otp'), 404);
        } else {

            $user = User::where('email', $request->email)->first();
            $user->password = bcrypt($request->password);
            $user->save();
            return $this->apiResponse(null,null, __('website.password_reset_successfully'), 200);
        }
        //
    }
}