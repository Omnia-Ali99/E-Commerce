<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class DynmicPageController extends Controller
{
    public function showDynmicPage($slug)
    {
        $page = Page::where('slug', $slug)->first();
        if ($page) {
            return view('website.dynmic-page', compact('page'));
        } else {
            abort('404');
        }

    }
}
