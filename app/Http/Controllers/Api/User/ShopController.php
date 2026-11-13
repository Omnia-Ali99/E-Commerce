<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    use ApiResponse;
    public function getProducts(Request $request)
    {
        $products = Product::with(['brand', 'category', 'images'])
            ->when(!empty($request->category_ids), fn($q) => $q->whereIn('category_id', $request->category_ids))
            ->when(!empty($request->brand_ids), fn($q) => $q->whereIn('brand_id', $request->brand_ids))
            ->when(!empty($request->price_range), function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->where('has_discount', 0)
                            ->whereBetween('price', $request->price_range);
                    })->orWhere(function ($query) use ($request) {
                        $query->where('has_discount', 1)
                            ->whereRaw('(price - discount) BETWEEN ? AND ?', $request->price_range);
                    })->orWhereRelation('variants', function ($query) use ($request) {
                        $query->whereBetween('price', $request->price_range);
                    });
                });
            })

            ->paginate(12);

        return $this->apiResponse(ProductResource::collection($products), true, 'products', 200);
    }
}
