<?php

use App\Http\Controllers\Website\HomeController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
        
    ], function(){ 

       Route::get('/',[HomeController::class,'index'])->name('website.home');
        
    });