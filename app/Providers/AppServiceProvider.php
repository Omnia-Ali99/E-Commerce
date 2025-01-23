<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        foreach(config('permessions_en') as $config_permession=>$value){
            Gate::define($config_permession , function($auth) use($config_permession){
                return $auth->hasAccess($config_permession);
            });
        }
    }
}
