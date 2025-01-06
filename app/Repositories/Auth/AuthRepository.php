<?php

namespace App\Repositories\Auth;

use Illuminate\Support\Facades\Auth;

class AuthRepository
{

    public function login($credentials,  $guard, $remember = false)
    {

        return Auth::guard($guard)->attempt($credentials,  $guard, $remember);
    }
    public function logout($guard)
    {
        Auth::guard($guard)->logout();
    }
}
