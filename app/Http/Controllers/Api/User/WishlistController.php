<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Wishlist;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\WishlistResource;

class WishlistController extends Controller
{
    use ApiResponse;
    public function getAll()
    {
        $products = Wishlist::WithProductDetails()->get();

        return $this->apiResponse([
            'data' => WishlistResource::collection($products),
        ], true, __('website.products'), 200);
    }

    public function add(Request $request)
    {
        $exists = Wishlist::where('user_id', auth('api')->user()->id)
            ->where('product_id', $request->product_id)->exists();
        if ($exists) {
            return $this->apiResponse([], false, 'product already exists in wishlist', 400);
        }

        $wishlist = Wishlist::create([
            'user_id' => auth('api')->user()->id,
            'product_id' => $request->product_id,
        ]);

        $wishlist = Wishlist::WithProductDetails()->find($wishlist->id);

        return $this->apiResponse(
            [
                'data' => WishlistResource::make($wishlist)
            ],
            true,
            __('website.product_added_to_wishlist'),
            201
        );
    }
    public function remove($id)
     {

        $wishlist = Wishlist::find($id);
        if(!$wishlist){
            return $this->apiResponse([], false, __('website.product_not_found_in_wishlist'), 404);
        }
        $wishlist->delete();
        return $this->apiResponse([], true, __('website.product_removed_from_wishlist'), 200);
     }
    public function clear()
     {
        if(auth('api')->user()->wishlists()->count() == 0){
            return $this->apiResponse([], false, __('website.wishlist_is_empty'), 404);
        }
        auth('api')->user()->wishlists()->delete();
        return $this->apiResponse([], true, __('website.wishlist_cleared'), 200);
     }

     public function wishlistCount()
     {
        return $this->apiResponse([
            'count' => auth('api')->user()->wishlists()->count()
        ], true, __('website.wishlist_count'), 200);
     }
}