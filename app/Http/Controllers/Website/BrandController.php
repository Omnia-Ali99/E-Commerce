<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Services\Website\HomeService;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    protected $homeService;
    public function __construct(HomeService $home_service)
    {
        $this->homeService = $home_service;
    }
    public function getBrands()
    {
        $brands = $this->homeService->getBrands();
        return view('website.brands', compact('brands'));
    }

    public function getProductsByBrand($slug)
    {
        $products = $this->homeService->getProductsByBrand($slug);
        return view('website.products', compact('products'));
    }
}
