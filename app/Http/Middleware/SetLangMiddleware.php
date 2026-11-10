<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLangMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get 'lang' from header (e.g., "en", "ar", etc.)
        $lang = $request->header('lang', 'en');


        // Define supported languages
        $supported = ['en', 'ar'];

        // Check if language is supported, then set locale
        if ($lang && in_array($lang, $supported)) {
            App::setLocale($lang);
        }
        return $next($request);
    }
}
