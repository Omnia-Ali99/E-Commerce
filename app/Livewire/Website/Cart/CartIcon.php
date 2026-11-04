<?php

namespace App\Livewire\Website\Cart;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class CartIcon extends Component
{

    public function removeItemFromCart($id)
    {
        $authBoolean = auth('web')->check();
        if ($authBoolean) {
            $cart = auth('web')->user()->cart()->firstOrCreate();
            $cartItem = $cart->items()->where('id', $id)->first();

            if (! $cartItem) {
                return;
            }

            $cartItem->delete();
            $this->dispatch('updateCart');

            // delete coupon if the last item is deleted
            if ($cart->items()->count() == 0) {
                $cart->update(['coupon' => null]);
            }
        }

        // new code : make event to refresh checkout component in case opened
        $this->dispatch('orderSummaryRefresh');
    }

    #[On('refreshCartIcon')]
    public function render()
    {
        $authBoolean = auth('web')->check();
        $cart = $authBoolean ? auth('web')->user()->cart()->with('items')->firstOrCreate() : null;
        $cartItems = $cart?->items ?? collect();
        $cartItemsCount = $cartItems->count();

        return view('livewire.website.cart.cart-icon', [
            'cartItems' => $cartItems,
            'cartItemsCount' => $cartItemsCount,
        ]);
    }
}