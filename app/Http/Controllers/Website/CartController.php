<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
        public function showCartPage()
    {
        return view('website.cart');
    }
}
