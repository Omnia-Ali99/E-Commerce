<?php

namespace App\Http\Controllers\Website;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Website\HomeService;

class HomeController extends Controller
{
    protected $homeService;
    public function __construct(HomeService $home_service)
    {
        $this->homeService = $home_service;
    }
    public function index()
    {
        $sliders            = $this->homeService->getSliders();
        $someCategories     = $this->homeService->getCategories(12);
        $someBrands         = $this->homeService->getBrands(12);
        $homePageProducts   = $this->homeService->getHomePageProducts(12);

        return view('website.index',[
            'sliders'           => $sliders,
            'someCategories'    => $someCategories,
            'someBrands'        => $someBrands,
            'homePageProducts'  => $homePageProducts,


        ]);
    }


    public function showShopPage()
    {
        return view('website.shop');
    }

}