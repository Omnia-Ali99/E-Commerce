<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WishlistResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'wishlist_id' => $this->id,
            'product_id' => $this->product_id,
            'user_id' => $this->user_id,

            'product_name' => $this->product->name,

            'product_price' => $this->when(
                $this->product->has_variants == false,
                $this->product->price,
                $this->product->variants->first()?->price,
            ),
            'product_image' => $this->getImageUrl('uploads/products/' . $this->product->images->first()->file_name, 'products')


        ];
    }
}
