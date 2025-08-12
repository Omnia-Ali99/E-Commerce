<?php

namespace App\Services\Website;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class ProductService
{

    public function getProductBySlug($slug)
    {
        return Product::with('images', 'brand', 'category', 'productPreviews')
            ->select('id', 'sku', 'manage_stock', 'quantity', 'name', 'desc', 'small_desc', 'slug', 'price', 'has_variants', 'has_discount', 'discount', 'brand_id', 'category_id')
            ->where('slug', $slug)
            ->first();
    }

    public function getRelatedProductsBySlug($slug, $limit = null)
    {
        $categoryId = Product::whereSlug($slug)->first()->category_id;
        $products   = Product::with('images', 'brand', 'category')
            ->select('id', 'name', 'slug', 'price', 'has_variants', 'has_discount', 'discount', 'brand_id', 'category_id')
            ->whereCategoryId($categoryId)
            ->latest();

        if ($limit) {
            return $products->paginate($limit);
        }
        return $products->paginate(30);
    }

    public function newArrivalsProducts($limit = null)
    {
        $products = Product::query()->with('images', 'brand', 'category')
            ->active()
            ->latest()
            ->select('id', 'name', 'slug', 'price', 'has_variants', 'has_discount', 'discount', 'brand_id', 'category_id');
        if ($limit) {
            return $products->paginate($limit);
        }
        return $products->paginate(30);
    }
    public function getFlashProducts($limit = null)
    {
        $products =  Product::query()->with('images', 'brand', 'category')
            ->active()
            ->where('has_discount', 1)
            ->latest()
            ->select('id', 'name', 'slug', 'price', 'has_variants', 'has_discount', 'discount', 'brand_id', 'category_id');
        if ($limit) {
            return $products->paginate($limit);
        }
        return $products->paginate(30);
    }
    public function getFlashProductsWithTimer($limit = null)
    {
        $products = Product::query()->with('images', 'brand', 'category')
            ->active()
            ->where('available_for', date('Y-m-d'))->whereNotNull('available_for')
            ->where('has_discount', 1)
            ->latest()
            ->select('id', 'name', 'slug', 'price', 'has_variants', 'has_discount', 'discount', 'brand_id', 'category_id');
        if ($limit) {
            return $products->paginate($limit);
        }
        return $products->paginate(30);
    }

    public function getTopSellingProducts($limit = 10)
    {
        return Product::select('products.*', DB::raw('SUM(order_items.product_quantity) as total_sold'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->groupBy('products.id')
            ->orderByDesc('total_sold')
            ->take($limit)
            ->get();
    }

}