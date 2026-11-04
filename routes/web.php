<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Website\BrandController;
use App\Http\Controllers\Website\CartController;
use App\Http\Controllers\Website\CategoryController;
use App\Http\Controllers\Website\CheckoutController;
use App\Http\Controllers\Website\ContactController;
use App\Http\Controllers\Website\DynamicPageController;
use App\Http\Controllers\Website\FaqController;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\ProductController;
use App\Http\Controllers\Website\ProfileController;
use App\Http\Controllers\Website\WishlistController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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
            Route::get('register', 'showRegistrationForm')->name('register.get');
            Route::post('register', 'register')->name(name: 'register.post');
        });
        Route::controller(LoginController::class)->group(function () {
            Route::get('login', 'showLoginForm')->name('login.get');
            Route::post('login', 'login')->name('login.post');
            Route::post('logout', 'logout')->name('logout');
        });



        Route::get('/', [HomeController::class, 'index'])->name('website.home');

        ################################## Profile ####################################
        Route::group(['middleware' => 'auth:web'], function () {

            Route::controller(ProfileController::class)->group(function () {
                Route::get('user-profile', 'showProfile')->name('profile');
            });
        });


        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/page/{slug}', [DynamicPageController::class, 'showDynamicPage'])->name('dynamic-page');
        Route::get('/faq', [FaqController::class, 'faqShowPage'])->name('faqs.index');
        Route::get('contacts',     [ContactController::class, 'index'])->name('contacts.get');

        ################################# Brands Routes ######################################
        Route::prefix('brands')->name('brands.')->controller(BrandController::class)->group(function () {
            Route::get('/', 'getBrands')->name('index');
            Route::get('/{slug}/products', 'getProductsByBrand')->name('products');
        });
        ################################# Categories Routes ######################################
        Route::prefix('categories')->name('categories.')->controller(CategoryController::class)->group(function () {
            Route::get('/', 'getCategories')->name('index');
            Route::get('/{slug}/products', 'getProductsByCategory')->name('products');
        });
        ################################# Products Routes ######################################
        Route::prefix('products')->name('products.')->controller(ProductController::class)->group(function () {
            Route::get('/{type}', 'getProductsByType')->name('by.type');
            Route::get('/show/{slug}', 'showProductPage')->name('show');
            Route::get('/{slug}/related-products', 'relatedProducts')->name('related');
        });

        ################################## Shop ####################################
        Route::get('shop', [HomeController::class, 'showShopPage'])->name('shop');

          ################################## Profile ####################################
        Route::group(['middleware' => 'auth:web'], function () {

            Route::controller(ProfileController::class)->group(function () {
                Route::get('user-profile',  'showProfile')->name('profile');
            });
            ################################ Wishlist Routes ##########################
            Route::get('wishlist',  WishlistController::class)->name('wishlist');

             ################################ Cart Routes ##############################
            Route::get('cart', [CartController::class, 'showCartPage'])->name('cart');

            ################################ Payment Routes ##############################
            Route::get('checkout',              [CheckoutController::class, 'showCheckoutPage'])->name('checkout.get');
            Route::post('checkout',             [CheckoutController::class, 'checkout'])->name('checkout.post');
            Route::get('checkout/stripe/success', [CheckoutController::class, 'stripeSuccess'])->name('checkout.stripe.success');
            Route::get('checkout/stripe/cancel',  [CheckoutController::class, 'stripeCancel'])->name('checkout.stripe.cancel');
        });

});
Auth::routes([
    'login' => false,
    'register' => false,
]);
