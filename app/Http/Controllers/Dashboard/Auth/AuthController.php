<?php

namespace App\Http\Controllers\Dashboard\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateAdminRequest;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class AuthController extends Controller implements HasMiddleware
{
    public static function middleware(){
        return [
            new Middleware(middleware: 'guest:admin', except: ['Logout']),
        ];
    }
    public function ShowLoginForm(){
        return view('dashboard.auth.login');
    }
    public function Login(CreateAdminRequest $request){

        $email =$request->email;
        $password = $request->password;
        if(Auth::guard('admin')->attempt(['email'=>$email,'password'=>$password],true)){
            return redirect()->intended(route('dashboard.welcome'));
        }else{
            return redirect()->back()->withErrors(['email'=>__('auth.not_match')]);
        }
   
    }

    public function Logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('dashboard.login');
    }
}
