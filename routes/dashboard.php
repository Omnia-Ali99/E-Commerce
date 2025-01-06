<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\WelcomeController;
use App\Http\Controllers\Dashboard\Auth\AuthController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Dashboard\Auth\ResetPasswordController;
use App\Http\Controllers\Dashboard\Auth\ForgotPasswordController;

Route::group(
  [
    'prefix' => LaravelLocalization::setLocale() . '/dashboard',
    'as' => 'dashboard.',
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
  ],
  function () {

    ##################################### Auth ##################################################
    Route::get('login', [AuthController::class, 'ShowLoginForm'])->name(name: 'login');
    Route::post('login', [AuthController::class, 'login'])->name(name: 'login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name(name: 'logout');

    ################################# Reset Password #############################
    Route::group(['prefix' => 'password', 'as' => 'password.'], function () {

      Route::controller(ForgotPasswordController::class)->group(function () {
        Route::get('email',          'showEmailForm')->name('email');
        Route::post('email',         'sendOtp')->name('email.post');
        Route::get('verify/{email}', 'showOtpForm')->name('verify');
        Route::post('verify/',       'verifyOtp')->name('verify.post');
      });
      Route::controller(ResetPasswordController::class)->group(function () {
        Route::get('reset/{email}', 'showResetForm')->name('reset');
        Route::post('reset',         'resetPassword')->name('reset.post');
      });
    });
    ################################## End Pssword #################################
    ##################################### Protected Routes ###############################################
    Route::group(['middleware' => 'auth:admin'], function () {

      ##################################### Welcome Routes ##################################################
      Route::get('/welcome', [WelcomeController::class, 'index'])->name('welcome');
    });
  }
);
route::get('email', function () {

  return view('dashboard.auth.password.email');
});
