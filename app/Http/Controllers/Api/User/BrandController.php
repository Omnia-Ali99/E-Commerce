<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use App\Services\Website\HomeService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    use ApiResponse;
    protected $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function getBrands()
    {
        $brands = $this->homeService->getBrands();
        return $this->apiResponse([
            'brands' => BrandResource::collection($brands),
        ], true, __('website.brands'), 200);
    }
}
