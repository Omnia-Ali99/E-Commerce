<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Models\Admin;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\SendOtpNotify;

class ForgotPasswordController extends Controller
{

    protected $otp2;
    public function __construct()
    {
        $this->otp2 = new Otp;
    
    }

    public function showEmailForm()
    {
        return view('dashboard.auth.password.email');
    }
    public function sendOtp(Request $request){
         
        $request->validate(['email' =>['required','email']]);
        $admin =Admin::where('email',$request->email)->first();

        if(! $admin){
            return redirect()->back()->withErrors(['email' => __('passwords.email_is_not_regiterd')]);
        }
        $admin->notify(new SendOtpNotify());

        return redirect()->route('dashboard.password.verify' , ['email'=>$admin->email]);


    }
    public function showOtpForm($email){

        return view('dashboard.auth.password.verify' , ['email'=>$email]);
    }
    public function verifyOtp(Request $request)
    {
         $request->validate([
            'email'=> ['required','email'],
            'code' => ['required','min:5'],
         ]);

         $otp = $this->otp2->validate($request->email,$request->code);
        if($otp->status == false){
            return redirect()->back()->withErrors(['error'=>'Code is invalid!']);
        }
        return redirect()->route('dashboard.password.reset' , ['email'=>$request->email]);

    }

}
