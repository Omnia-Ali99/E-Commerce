<?php

namespace App\Providers;

use App\Models\Faq;
use App\Models\Page;
use App\Models\Admin;
use App\Models\Brand;
use App\Models\Coupon;
use App\Models\Contact;
use App\Models\Setting;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        view()->composer('dashboard.*', function ($view) {

            if (!Cache::has('categories_count')) {
                Cache::remember('categories_count', now()->addMinutes(60), function () {
                    return Category::count();
                });
            }
            if (!Cache::has('faqs_count')) {
                Cache::remember('faqs_count', now()->addMinutes(60), function () {
                    return Faq::count();
                });
            }
            if (!Cache::has('coupons_count')) {
                Cache::remember('coupons_count', now()->addMinutes(60), function () {
                    return Coupon::count();
                });
            }
            if (!Cache::has('brands_count')) {
                Cache::remember('brands_count', now()->addMinutes(60), function () {
                    return Brand::count();
                });
            }
            if (!Cache::has('admins_count')) {
                Cache::remember('admins_count', now()->addMinutes(60), function () {
                    return Admin::count();
                });
            }
              if (!Cache::has('contacts_count')) {
                Cache::remember('contacts_count', now()->addMinutes(60), function () {
                    return Contact::where('is_read', 0)->count();
                });
            }



            view()->share([
                'categories_count' => Cache::get('categories_count'),
                'faqs_count' => Cache::get('faqs_count'),
                'brands_count' => Cache::get('brands_count'),
                'admins_count' => Cache::get('admins_count'),
                'coupons_count' => Cache::get('coupons_count'),
                'contacts_count' => Cache::get('contacts_count'),

            ]);
        });

             // share website variables
        view()->composer('website.*', function ($view) {

            $pages = Page::select('id', 'slug', 'title')->get();

            view()->share([
                'pages' => $pages,
                
            ]);
        });

        // get Setting And Share
        $setting = $this->firstOrCreateSetting();

        view()->share([
            'setting' => $setting,
        ]);
    }
    public function firstOrCreateSetting()
    {
        $getSetting = Setting::firstOr(function () {
            return Setting::create([
                'site_name' => [
                    'ar' => 'متجر الكتروني',
                    'en' => 'E-Commerce',
                ],
                'site_desc' => [
                    'en' => 'This is E-Commerce website',
                    'ar' => 'هذا موقع متجر الكتروني ',
                ],
                'site_address' => [
                    'en' => 'Egypt , Alex , Mandara',
                    'ar' => 'مصر , الاسكندريه ,  المندره',
                ],
                'site_phone' => '01222220000',
                'site_email' => 'e-commerce@gmail.com',
                'email_support' => 'e-commerceSupport@gmail.com',

                // socail
                'facebook_url' => 'https://www.facebook.com/',
                'twitter_url' => 'https://www.twitter.com/',
                'youtube_url' => 'https://www.youtube.com/',

                'logo' => 'logo.png',
                'favicon' => 'logo.png',
                'site_copyright' => '©2025 Your E-commerce Name. All rights reserved.',

                'meta_description' => [
                    'en' => '23 of PARAGE is equality of condition, blood, or dignity; specifically',
                    'ar' => '23 of PARAGE is equality of condition, blood, or dignity; specifically ',
                ],
                'promotion_video_url' => 'https://www.youtube.com/embed/SsE5U7ta9Lw?rel=0&amp;controls=0&amp;showinfo=0',

            ]);
        });
        return $getSetting;
    }
}
