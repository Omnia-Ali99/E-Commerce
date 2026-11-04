<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Services\Website\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
      public $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function showProductPage($slug)
    {
        $product = $this->productService->getProductBySlug($slug);
        if(!$product){
            abort(404);
        }
        $relatedProducts = $this->productService->getRelatedProductsBySlug($product->slug,4);

        return view('website.show', compact('product','relatedProducts'));
    }

    public function relatedProducts($productSlug)
    {
        $relatedProducts = $this->productService->getRelatedProductsBySlug($productSlug);
        return view('website.products',[
            'products'=>$relatedProducts,
            'flash_timer'=>false
        ]);
    }

    public function getProductsByType($type)
    {
        if($type == 'new-arrivals'){
            $products = $this->productService->newArrivalsProducts();

        }elseif($type == 'flash-products'){
            $products = $this->productService->getFlashProducts();

        }elseif($type == 'flash-timers'){
            $products = $this->productService->getFlashProductsWithTimer();

        }else{
            abort(404);
        }

        return view('website.products' , [
            'products'=>$products,
            'flash_timer'=>$type == 'flash-timers' ? true : false
        ]);
    }
}
