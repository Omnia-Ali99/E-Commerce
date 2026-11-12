<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageResource;
use App\Models\Page;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class DynamicPageController extends Controller
{
    use ApiResponse;

    public function getPages()
    {
        $pages = Page::get();
        return $this->apiResponse([
            'pages' => PageResource::collection($pages),
        ], true, __('website.pages'), 200);
    }
}
