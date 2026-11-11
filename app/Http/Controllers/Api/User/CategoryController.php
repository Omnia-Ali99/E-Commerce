<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Services\Website\HomeService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ApiResponse;
    protected $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function getCategories()
    {
        $categories = $this->homeService->getCategories();
        return $this->apiResponse([
            'categories' => CategoryResource::collection($categories),
        ], true, __('website.categories'), 200);
    }
}
