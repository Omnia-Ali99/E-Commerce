<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductDetailsResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\Website\HomeService;
use App\Services\Website\ProductService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponse;
    protected $homeService, $productService;

    public function __construct(HomeService $homeService, ProductService $productService)
    {
        $this->homeService = $homeService;
        $this->productService = $productService;
    }

    public function flashProducts()
    {
        $palshProducts = $this->productService->newArrivalsProducts();
        return $this->apiResponse([
            'flash_products' => ProductResource::collection($palshProducts),
        ], true, __('website.products'), 200);
    }

    public function productDetails($product_id)
    {
        $product =  Product::with('images', 'brand', 'category', 'productPreviews', 'variants.VariantAttributes.attributeValue.attribute')
            ->select('id', 'sku', 'manage_stock', 'quantity', 'name', 'desc', 'small_desc', 'slug', 'price', 'has_variants', 'has_discount', 'discount', 'brand_id', 'category_id')
            ->where('id', $product_id)
            ->first();

        if (!$product) {
            return $this->apiResponse(null, false, __('website.product_not_found'), 404);
        }

        return $this->apiResponse(new ProductDetailsResource($product), true, __('website.product_details'), 200);
    }
}
