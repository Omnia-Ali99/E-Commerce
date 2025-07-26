<?php

namespace App\Http\Controllers\Dashboard\Auth;

use Illuminate\Http\Request;
use App\Services\Auth\AuthService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateAdminRequest;
use App\Http\Requests\LoginAdminRequest;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class AuthController extends Controller //implements HasMiddleware
{
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
        $this->middleware('guest:admin')->except('logout');
    }
    // public static function middleware()
    // {
    //     return [
    //         new Middleware(middleware: 'guest:admin', except: ['logout']),
    //     ];
    // }
    public function ShowLoginForm()
    {
        return view('dashboard.auth.login');
    }
    public function login(LoginAdminRequest $request)
    {

        $credentials = $request->only(['email', 'password']);
        if ($this->authService->login($credentials, 'admin', $request->remember)) {

            return redirect()->intended(route('dashboard.welcome'));
        } else {
            return redirect()->back()->withErrors(['email' => __('auth.not_match')]);
        }
    }

    public function logout()
    {
        $this->authService->logout('admin');
        return redirect()->route('dashboard.login');
    }
}
