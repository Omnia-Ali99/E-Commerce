<?php

use Livewire\Livewire;
use App\Http\Controllers\Dashboard\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\{
  FaqController,
  RoleController,
  AdminController,
  BrandController,
  WorldController,
  CouponController,
  SettingController,
  WelcomeController,
  CategoryController,
  ContactController,
    PageController,
    SliderController,
  UserController,
};

use App\Http\Controllers\Dashboard\AttributeController;
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
    Route::get('login', [AuthController::class, 'ShowLoginForm'])->name('login');
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

      ##################################### Roles Routes ##################################################

      Route::group(['middleware' => 'can:roles'], function () {
        Route::resource('roles', RoleController::class);
      });

      ##################################### End Roles  ##################################################

      ##################################### Admins Routes ##################################################

      Route::group(['middleware' => 'can:admins'], function () {
        Route::resource('admins', AdminController::class);
        Route::get('admins/{id}/status', [AdminController::class, 'changeStatus'])->name('admins.status');
      });
      ##################################### End Admins  ##################################################

      ############################ Shipping & Countries ##########################
      Route::group(['middleware' => 'can:global_shipping'], function () {
        Route::controller(WorldController::class)->group(function () {

          Route::prefix('countries')->name('countries.')->group(function () {
            Route::get('/',                              'getAllCountries')->name('index');
            Route::get('/{country_id}/governorates',     'getGovsByCountry')->name('governorates.index');
            Route::get('/change-status/{country_id}',    'changeStatus')->name('status');
          });

          Route::prefix('governorates')->name('governorates.')->group(function () {
            Route::get('/change-status/{gov_id}',       'changeGovStatus')->name('status');
            Route::put('/shipping-price',               'changeShippingPrice')->name('shipping-price');
          });
        });
      });
      ############################### End Shipping ###############################

      ##################################### Categories Routes ##################################################
      Route::group(['middleware' => 'can:categories'], function () {
        Route::resource('categories', CategoryController::class)->except('show');
        Route::get('categories-all', [CategoryController::class, 'getAll'])
          ->name('categories.all');
      });
      ##################################### End Categories  ##################################################

      ##################################### Brands Routes ##################################################
      Route::group(['middleware' => 'can:brands'], function () {
        Route::resource('brands', BrandController::class);
        Route::get('brands-all', [BrandController::class, 'getAll'])
          ->name('brands.all');
      });
      ##################################### End Brands  ##################################################

      ##################################### Coupons Routes ##################################################
      Route::group(['middleware' => 'can:coupons'], function () {
        Route::resource('coupons', CouponController::class)->except('show');
        Route::get('coupons-all', [CouponController::class, 'getAll'])
          ->name('coupons.all');
      });
      ##################################### End Coupons  ##################################################

      ##################################### Faqs Routes ##################################################
      Route::group(['middleware' => 'can:faqs'], function () {
        Route::resource('faqs', FaqController::class);
        Route::get('faqs-all', [FaqController::class, 'getAll'])
          ->name('faqs.all');
      });
      ##################################### End Faqs  ##################################################

      ############################### Settings Routes ###############################
      Route::group(['middleware' => 'can:settings', 'as' => 'settings.'], function () {
        Route::get('settings',      [SettingController::class, 'index'])->name('index');
        Route::put('settings/{id}', [SettingController::class, 'update'])->name('update');
      });
      ############################### End Settings ##################################

      ############################### Attributes Routes #############################
      Route::group(['middleware' => 'can:attributes'], function () {
        Route::resource('attributes', AttributeController::class);
        Route::get('attributes-all', [AttributeController::class, 'getAll'])
          ->name('attributes.all');
      });
      ############################### End attributes ################################

      ############################### Products Routes ###############################
      Route::group(['middleware' => 'can:products'], function () {
        Route::resource('products', ProductController::class);
        Route::post('products/status', [ProductController::class, 'changeStatus'])
          ->name('products.status');
        Route::get('products-all', [ProductController::class, 'getAll'])
          ->name('products.all');

        //Variants
        Route::get('products/variants/{variant_id}', [ProductController::class, 'deleteVariant'])
          ->name('products.variants.delete');
      });
      ############################### End products ################################

      ############################### users Routes #############################
      Route::group(['middleware' => 'can:users'], function () {
        Route::resource('users', UserController::class);
        Route::post('users/status', [UserController::class, 'changeStatus'])
          ->name('users.status');
        Route::get('users-all', [UserController::class, 'getAll'])
          ->name('users.all');
      });
      ############################### End users ################################


      ############################### Contact Routes ##############################
      Route::group(['middleware' => 'can:contacts'], function () {
        Route::get('contacts',          [ContactController::class, 'index'])->name('contacts.index');

        Route::get('contacts-get/{id}', [ContactController::class, 'getContactById'])->name('contacts.get');
      });
      ############################### End Contacts ################################

      ############################### Sliders Routes ##############################
      Route::group(['middleware' => 'can:sliders'], function () {
        Route::get('sliders',         [SliderController::class, 'index'])->name('sliders.index');
        Route::post('sliders',        [SliderController::class, 'store'])->name('sliders.store');
        Route::get('sliders-all',     [SliderController::class, 'getAll'])->name('sliders.all');
        Route::get('remove/{id}',     [SliderController::class, 'destroy'])->name('sliders.delete');
      });
      ############################### End Sliders ################################
      
      ############################### Pages Routes #############################
      Route::group(['middleware' => 'can:pages'], function () {
        Route::resource('pages', PageController::class);
        Route::get('pages-all', [PageController::class, 'getAll'])
          ->name('pages.all');
      });
      ############################### End pages ################################

    });

    Livewire::setUpdateRoute(function ($handle) {
      return Route::post('/livewire/update', $handle);
    });
  }
);
