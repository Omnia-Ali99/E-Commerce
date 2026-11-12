<?php

use App\Http\Controllers\Api\User\AddressController;
use App\Http\Controllers\Api\User\Auth\LoginController;
use App\Http\Controllers\Api\User\Auth\Password\PasswordController;
use App\Http\Controllers\Api\User\Auth\RegisterController;
use App\Http\Controllers\Api\User\BrandController;
use App\Http\Controllers\Api\User\CategoryController;
use App\Http\Controllers\Api\User\DynamicPageController;
use App\Http\Controllers\Api\User\ProductController;
use App\Http\Controllers\Api\User\WishlistController;
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

        Route::controller(CategoryController::class)->group(function () {
            Route::get('get-categories', 'getCategories');
        });

        Route::controller(BrandController::class)->group(function () {
            Route::get('get-brands', 'getBrands');
        });

        Route::controller(AddressController::class)->group(function () {
            Route::get('get-countries', 'getCountries');
            Route::get('get-governorates/{country_id}', 'getGovernorates');
            Route::get('get-cities/{governorate_id}', 'getCities');
        });

        Route::prefix('products/')->controller(ProductController::class)->group(function () {
            Route::get('get-flash-products', 'flashProducts');
            Route::get('product-details/{id}', 'productDetails');
        });

        Route::controller(DynamicPageController::class)->group(function () {
            Route::get('get-pages', 'getPages');
        });

        Route::group(['middleware' => 'auth:api'], function () {
            Route::controller(WishlistController::class)->prefix('wishlist')->group(function () {
                Route::get('/', 'getAll');
                Route::post('/', 'add');
                Route::delete('/{id}', 'remove');
                Route::delete('/delete/all', 'clear');
                Route::get('/count', 'wishlistCount');
            });
        });
    }
);
