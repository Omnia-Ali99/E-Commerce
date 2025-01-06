<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResetPasswordController extends Controller
{

    public function showResetForm($email)
    {
        return view('dashboard.auth.password.reset', ['email' => $email]);
    }
    public function resetPassword(Request $request){
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'password_confirmation' => ['required'],
        ]);

        $admin =Admin::where('email',$request->email)->first();
        if (!$admin) {
            return redirect()->back()->with(['error' => 'Try Again Latter!']);
        }
        $admin->update([
            'password' => bcrypt($request->password),
        ]);
        return redirect()->route('dashboard.login')->with('success' , 'Your Password Updated Successfully!');

    }
}
