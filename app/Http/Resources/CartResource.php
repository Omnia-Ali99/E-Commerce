<?php

namespace App\Http\Resources;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Resources\CartItemResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $shippingPrice = 0;
        $subTotal = 0;
        $counpoPrecentage = 0;
        $counpoAmount = 0;

        foreach ($this->items as $item) {
            $subTotal += $item->price * $item->quantity;
        }

        if ($this->additional['coupon_code'] != null) {
            $coupon = Coupon::where('code', $this->additional['coupon_code'])
                ->first();
            if ($coupon && $coupon->couponIsValid()) {
                $counpoPrecentage = $coupon->discount_precentage;
                $subTotal = $subTotal - ($subTotal * $counpoPrecentage / 100);
                $counpoAmount = $subTotal * $counpoPrecentage / 100;
            }

        }

        $shippingPrice = $this->additional['shippingPrice'] ?? 0;

        $total = $subTotal + $shippingPrice;


        return [
            'id' => $this->id,
            'coupon' => $this->coupon,
            'total_items' => $this->items->count(),
            'sub_total' => $subTotal,
            'coupon_precentage' => $counpoPrecentage,
            'coupon_amount' => round($counpoAmount, 2),
            'shipping_price' => $shippingPrice,
            'total' => $total,
            'items' => CartItemResource::collection($this->whenLoaded('items')),
        ];
    }
}