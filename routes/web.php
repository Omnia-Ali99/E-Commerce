<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Website\ProfileController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'as' => 'website.',
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']

    ],
    function () {
        ##################################### Auth ##################################################
        Route::controller(RegisterController::class)->group(function () {
            Route::get('register',  'showRegistrationForm')->name('register.get');
            Route::post('register',  'register')->name(name: 'register.post');
        });
        Route::controller(LoginController::class)->group(function () {
            Route::get('login',  'showLoginForm')->name('login.get');
            Route::post('login',  'login')->name(name: 'login.post');
        });



        Route::get('/', [HomeController::class, 'index'])->name('website.home');

        ################################## Profile ####################################
        Route::group(['middleware' => 'auth:web'], function () {

            Route::controller(ProfileController::class)->group(function () {
                Route::get('user-profile',  'showProfile')->name('profile');
            });
        });
    }
);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
