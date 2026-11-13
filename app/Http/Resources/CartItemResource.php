<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'product_variant_id' => $this->product_variant_id,
            'product_name' => $this->product->name,
            'product_image' => $this->getImageUrl('uploads/products/'.$this->product->images->first()->file_name,'products'),
            'quantity' => $this->quantity,
            'price' => $this->price,
            'total' => $this->quantity * $this->price,
            'attributes' => $this->attributes ? $this->attributes : null,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}