<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailsResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $images = $this->images->map(function ($image) {
            return 'uploads/products/' . $image->file_name;
        });
        return [
            'product_id' => $this->id,
            'product_name' => $this->name,
            'has_discount' => $this->has_discount ? 1 : 0,
            'discount' => $this->discount,
            'price_after_discount' => $this->price - $this->discount,


            'has_variants' => $this->has_variants ? 1 : 0,
            'all_images' => $this->getImagesUrls($images, 'products'),
            'brand_name' => $this->brand->name,
            'category_name' => $this->category->name,
            'in_wishlist' => auth('api')->check() ?  (auth('api')->user()->wishlists()->where('product_id', $this->id)->exists() ? 1 : 0) : 0,
            'date' => $this->formatDateLocliazed($this->created_at, app()->getLocale(), 'l, d F Y, h:i a'),
            'in_cart' => $this->when(
                auth('api')->check(),
                function () {
                    $cart = auth('api')->user()->cart->load('items');
                    return $cart->items()->where('product_id', $this->id)->exists() ? 1 : 0;
                },
                function () {
                    return 0;
                }
            ),

            'product_variants' => ProductVariantResource::collection($this->whenLoaded('variants')),

        ];
    }
}
