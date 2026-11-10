<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
     use ApiResponse;
    public function register(RegisterUserRequest $request)
    {
        $user = User::create($request->validated());
        $token = $user->createToken('user_auth_token', ['*'], now()->addWeek())->plainTextToken;
        return $this->apiResponse([
            'user' => new UserResource($user),
            'token' => $token,
        ], true, 'User Registered Successfully', 200);
    }
}
