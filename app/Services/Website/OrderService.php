<?php

namespace App\Services\Website;

use App\Models\Cart;
use App\Models\City;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Country;
use App\Models\Governorate;
use App\Models\Transaction;
use App\Models\ShippingGovernorate;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function getInvoiceValue($address)
    {
        $governorateName = $this->getLocationName(Governorate::class, $address['governorate_id']);

        $cart = $this->getUserCart();
        if (!$cart || $cart->items->isEmpty()) {
            return null;
        }

        $subTotal = $cart->items->sum(fn($item) => $item->price * $item->quantity);
        $shippingPrice = $this->getShippingPrice($address['governorate_id']);

        // check if user has coupon
        if ($coupon_exists = $cart->coupon != null) {
            $coupon = Coupon::valid()->where('code', trim($cart->coupon, ' '))->first();
            if ($coupon) {
                $subTotal = $subTotal - ($subTotal * $coupon->discount_precentage / 100);
            }
        }
        $totalPrice    = $subTotal + $shippingPrice;

        return $totalPrice;

    }

    public function createTransaction($data , $orderId)
    {
        return $this->createTransactionForGateway('myfatoorah', $data['Data']['InvoiceId'], $orderId);
    }

    public function createTransactionForGateway(string $gateway, string $transactionId, int $orderId)
    {
        $transaction = Transaction::create([
            'user_id' => Auth::guard()->user()->id,
            'order_id' => $orderId,
            'transaction_id' => $transactionId,
            'payment_method' => $gateway,
        ]);
        return $transaction;
    }

    public function createOrder(array $address): ?Order
    {
        $countryName     = $this->getLocationName(Country::class, $address['country_id']);
        $governorateName = $this->getLocationName(Governorate::class, $address['governorate_id']);
        $cityName        = $this->getLocationName(City::class, $address['city_id']);

        if (!$countryName || !$governorateName || !$cityName) {
            return null;
        }

        $cart = $this->getUserCart();
        if (!$cart || $cart->items->isEmpty()) {
            return null;
        }


        $subTotal = $cart->items->sum(fn($item) => $item->price * $item->quantity);
        $shippingPrice = $this->getShippingPrice($address['governorate_id']);

        // check if user has coupon
        if ($coupon_exists = $cart->coupon != null) {
            $coupon = Coupon::valid()->where('code', trim($cart->coupon, ' '))->first();
            if ($coupon) {
                $subTotal = $subTotal - ($subTotal * $coupon->discount_precentage / 100);
            }
        }
        $totalPrice    = $subTotal + $shippingPrice;

        // store order
        $order = Order::create([
            'user_id'        => auth()->user()->id,
            'user_name'      => $address['first_name'] . ' ' . $address['last_name'],
            'user_phone'     => $address['user_phone'],
            'user_email'     => $address['user_email'],
            'country'        => $countryName,
            'governorate'    => $governorateName,
            'city'           => $cityName,
            'street'         => $address['street'],
            'note'           => $address['note'],
            'price'          => $subTotal,
            'shapping_price' => $shippingPrice,
            'total_price'    => $totalPrice,
            'coupon'         => $coupon_exists && $coupon? $coupon->code : null,
            'coupon_discount'=> $coupon_exists && $coupon? $coupon->discount_precentage : 0,
        ]);

        $this->storeOrderItemsFromCart($order, $cart);

        return $order;
    }

    private function getLocationName(string $modelClass, int $id): ?string
    {
        return $modelClass::find($id)?->name;
    }

    private function getUserCart(): ?Cart
    {
        return Cart::with('items.product')->where('user_id', auth()->user()->id)->first();
    }

    private function getShippingPrice(int $governorateId): float
    {
        return ShippingGovernorate::where('governorate_id', $governorateId)->value('price') ?? 0.0;
    }

    private function storeOrderItemsFromCart(Order $order, Cart $cart): void
    {
        foreach ($cart->items as $item) {
            $order->orderItems()->create([
                'product_id'         => $item->product_id,
                'product_variant_id' => $item->product_variant_id,
                'product_name'       => optional($item->product)->name ?? 'Unknown Product',
                'product_desc'       => optional($item->product)->small_desc ?? '',
                'product_quantity'   => $item->quantity,
                'product_price'      => $item->price,
                'attributes'         => json_encode($item->attributes),
            ]);
        }
    }

    public function clearUserCart(Cart $cart): void
    {
        $cart->items()->delete();
        $cart->update(['coupon'=>null]); // clear coupon
    }
}