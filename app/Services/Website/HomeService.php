<?php

namespace App\Services\Website;

use App\Models\Brand;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class HomeService
{

    protected $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function getProducts($limit = null)
    {
        if ($limit == null) {
            return Product::active()->get();
        }
        return Product::active()->limit($limit)->get();
    }
    public function getSliders()
    {
        return Slider::get();
    }

    public function getCategories($limit = null)
    {
        if ($limit == null) {
            return Category::active()->get();
        }
        return Category::active()->limit($limit)->get();
    }

    public function getBrands($limit = null)
    {
        if ($limit == null) {
            return Brand::active()->get();
        }
        return Brand::active()->limit($limit)->get();
    }
    // get Products By Categories&Brands
    public function getProductsByBrand($slug)
    {
        $brand_id = Brand::where('slug', $slug)->first()->id;

        return Product::with('images', 'brand', 'category')
            ->active()
            ->latest()
            ->select('id', 'name', 'slug', 'price', 'has_variants', 'has_discount', 'discount', 'brand_id', 'category_id')
            ->where('brand_id', $brand_id)
            ->paginate(2);
    }
    public function getProductsByCategory($slug)
    {
        $category_id = Category::where('slug', $slug)->first()->id;

        return Product::with('images', 'brand', 'category')
            ->active()
            ->latest()
            ->select('id', 'name', 'desc', 'slug', 'price', 'has_variants', 'has_discount', 'discount', 'brand_id', 'category_id')
            ->where('category_id', $category_id)
            ->paginate(2);
    }

    public function getHomePageProducts($limit = null): array
    {
        return [
            'newArriavals'       => $this->productService->newArrivalsProducts($limit),
            'flashProducts'      => $this->productService->getFlashProducts($limit),
            'flashProductsTimer' => $this->productService->getFlashProductsWithTimer($limit),
            // 'topSellingProducts' => $this->productService->getTopSellingProducts($limit),
        ];
    }
}