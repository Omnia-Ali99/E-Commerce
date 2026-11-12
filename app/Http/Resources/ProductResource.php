<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends BaseResource
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
            'base_image' => $this->getImageUrl('uploads/products/' . $this->images->first()->file_name, 'products'),

            'product_price' => $this->when(
                $this->has_variants == false,
                function () {
                    return [
                        'product_price' => round($this->price, 2),
                        'price_after_discount' => $this->price - $this->discount,
                    ];
                },
                function () {
                    // in case product has variants
                    $maxPriceVariant = $this->variants()->orderByDesc('price')->first();
                    $minPriceVariant = $this->variants()->orderBy('price')->first();
                    return [
                        'max_price' => $maxPriceVariant->price,
                        'min_price' => $minPriceVariant->price,
                    ];
                }
            ),

            'all_images' => $this->getImagesUrls($images, 'products'),
            'has_variants' => $this->has_variants ? 1 : 0,
            'brand_name' => $this->brand->name,
            'category_name' => $this->category->name,

            'date'=>$this->formatDateLocliazed($this->created_at , app()->getLocale(),'l, d F Y, h:i a'),
            'in_wishlist' => auth('api')->check() ?  (auth('api')->user()->wishlists()->where('product_id', $this->id)->exists() ? 1 : 0) :0,

        ];
    }
}