<?php

use App\Http\Controllers\Api\User\AddressController;
use App\Http\Controllers\Api\User\Auth\LoginController;
use App\Http\Controllers\Api\User\Auth\Password\PasswordController;
use App\Http\Controllers\Api\User\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(
    [
        'prefix' => 'user'
    ],
    function () {

        Route::post('register', [RegisterController::class, 'register']);
        Route::post('login', [LoginController::class, 'login']);
        Route::post('logout', [LoginController::class, 'logout'])
            ->middleware('auth:api');

        Route::controller(PasswordController::class)->group(function () {
            Route::post('forgot-password', 'forgotPassword');
            Route::post('reset-password', 'resetPassword');
        });

        Route::controller(AddressController::class)->group(function () {
            Route::get('get-countries', 'getCountries');
            Route::get('get-governorates/{country_id}', 'getGovernorates');
            Route::get('get-cities/{governorate_id}', 'getCities');
        });

    }
);
