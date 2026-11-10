<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use ApiResponse;
    public function login(UserLoginRequest  $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || Hash::check($request->password, $user->password) == false) {

            return $this->apiResponse(null, false, __('auth.failed'), 401);
        }
          $token = $user->createToken('user_auth_token', ['*'], now()->addWeek())->plainTextToken;

        $data = ['user' => new UserResource($user->load(['country','governorate','city'])), 'token' => $token];
        return $this->apiResponse($data,true, __('website.user_login_successfully'), 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->apiResponse(null, true,__('website.user_logout_successfully'), 200);
    }
}
