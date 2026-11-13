<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ShippingGovernorate;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
     use ApiResponse;


    public function getAll(Request $request)
    {
        $shippingPrice = 0;
        $cart = auth('api')->user()->cart()->with('items')->first();

        if ($request->has('shipping_gov_id') && $request->shipping_gov_id != null) {
            $shippingPrice = ShippingGovernorate::where('id', $request->shipping_gov_id)
                ->first()
                ->price ?? 0;
        }
        if ($request->has('coupon_code') && $request->coupon_code != null) {
            $code = $this->applyCoupon($request->coupon_code, $cart);

            if ($code instanceof JsonResponse) {
                return $code;
            }

            $cart->update([
                'coupon' => $code,
            ]);
        }

        return $this->apiResponse([
            'data' => (new CartResource($cart))->additional([
                'shippingPrice' => $shippingPrice,
                'coupon_code' => $cart->coupon,
            ]),
        ], true, 'products', 200);
    }
    public function applyCoupon($coupon_code, $cart)
    {
        $copoun = Coupon::where('code', $coupon_code)->first();
        if (!$copoun || !$copoun->couponIsValid()) {
            return $this->apiResponse([], false, 'Coupon not valid', 404);
        }
        if ($cart->coupon != null) {
            return $this->apiResponse(null, false, 'delete old coupon first', 404);
        }
        return $copoun->code;
    }

    public function addToCart(Request $request)
    {
        $cart = auth('api')->user()->cart;

        $product = Product::find($request->product_id);
        if (!$product) {
            return $this->apiResponse(null, false, 'Product not found', 404);
        }

        if ($product->has_variants) {
            $exists = $cart->items()->where('product_id', $request->product_id)
                ->where('product_variant_id', $request->product_variant_id)
                ->exists();
        } else {
            $exists = $cart->items()->where('product_id', $request->product_id)->exists();
        }

        if ($exists) {
            return $this->apiResponse(null, false, 'Product already exists in cart', 409);
        }

        if (!$product->has_variants) {
            $cart->items()->create([
                'product_id' => $request->product_id,
                'product_variant_id' => null,
                'price' => $product->has_discount ? $product->price - $product->discount : $product->price,
                'quantity' => 1,
            ]);
        } else {
            $variant = $product->variants->find($request->product_variant_id);
            if(!$variant){
                return $this->apiResponse(null, false, 'Variant not found', 404);
            }
            $variant->load('VariantAttributes');
            $cartAttributesArray = [];
            foreach ($variant->VariantAttributes as $variantAttr) {
                $cartAttributesArray[$variantAttr->attributeValue->attribute->name] = $variantAttr->attributeValue->value;
            }

            $item = $cart->items()->create([
                'product_id' =>  $product->id,
                'product_variant_id' => $variant->id,
                'price' => $variant->price,
                'quantity' => 1,
                'attributes' => json_encode($cartAttributesArray, JSON_UNESCAPED_UNICODE)
            ]);
        }

        return $this->apiResponse([], true, 'Product added to cart successfully', 200);
    }

    public function increment($item_id)
    {
        $item = CartItem::find($item_id);
        if (!$item) {
            return $this->apiResponse([], false, 'Item not found', 404);
        }
        $item->increment('quantity');
        return $this->apiResponse([
            'quantity' => $item->quantity
        ], true, 'Item quantity incremented successfully', 200);
    }
    public function decrement($item_id)
    {
        $item = CartItem::find($item_id);
        if (!$item) {
            return $this->apiResponse([], false, 'Item not found', 404);
        }
        if ($item->quantity == 1) {
            return $this->apiResponse([], false, 'Item quantity cannot be less than 1', 400);
        }
        $item->decrement('quantity');
        return $this->apiResponse([
            'quantity' => $item->quantity
        ], true, 'Item quantity decremented successfully', 200);
    }

    public function removeItem($item_id)
    {
        $item = CartItem::find($item_id);
        if (!$item) {
            return $this->apiResponse([], false, 'Item not found', 404);
        }
        $item->delete();
        // delete coupon if the last item is deleted
        if (auth('api')->user()->cart->items->count() == 0) {
            auth('web')->user()->cart->update(['coupon' => null]);
        }
        return $this->apiResponse([], true, 'Item removed from cart successfully', 200);
    }

    public function clearCart()
    {
        if (auth('api')->user()->cart->items()->count() == 0) {
            return $this->apiResponse([], false, 'Cart is already empty', 400);
        }

        auth('api')->user()->cart->items()->delete();
        auth('api')->user()->cart->update(['coupon' => null]);
        return $this->apiResponse([], true, 'Cart cleared successfully', 200);
    }

    public function deleteCartCoupon($id)
    {
        if (auth('api')->user()->cart->id != $id) {
            return $this->apiResponse([], false, 'unauthorized', 401);
        }
        if (auth('api')->user()->cart->coupon == null) {
            return $this->apiResponse([], false, 'Coupon is not applied', 400);
        }
        auth('api')->user()->cart->update(['coupon' => null]);
        return $this->apiResponse([], true, 'Coupon deleted successfully', 200);
    }

}
