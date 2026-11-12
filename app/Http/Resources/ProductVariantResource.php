<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'stock' => $this->stock,
            'in_cart' => $this->when(
                auth('api')->check(),
                function () {
                    $cart = auth('api')->user()->cart->load('items');
                    return $cart->items()->where('product_variant_id', $this->id)->exists() ? 1 : 0;
                },
                function () {
                    return 0;
                }
            ),

            'variantAttributes' => VariantAttributeResource::collection($this->VariantAttributes),

        ];
    }
}
