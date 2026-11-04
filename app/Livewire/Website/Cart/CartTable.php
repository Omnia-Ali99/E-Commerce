<?php

namespace App\Livewire\Website\Cart;

use Livewire\Component;
use App\Models\CartItem;
use Livewire\Attributes\On;

class CartTable extends Component
{

    public function removeItem($itemId)
    {
        $item = CartItem::find($itemId);
        $item->delete();
        // delete coupon if the last item is deleted
        if (auth('web')->user()->cart->items->count() == 0) {
            auth('web')->user()->cart->update(['coupon' => null]);
        }
        $this->dispatch('refreshCartIcon');
    }
    public function increaseQuantity($itemId)
    {
        $item = CartItem::find($itemId);
        $item->quantity += 1;
        $item->save();
    }
    public function decreaseQuantity($itemId)
    {
        $item = CartItem::find($itemId);
        if ($item->quantity > 1) {
            $item->quantity -= 1;
            $item->save();
        }
    }

    public function clearCart()
    {
        $authUser = auth('web')->user();
        $cart = $authUser->cart;
        $cart->items()->delete();
        // delete coupon if the last item is deleted
        if (auth('web')->user()->cart->items->count() == 0) {
            auth('web')->user()->cart->update(['coupon' => null]);
        }
        $this->dispatch('refreshCartIcon');
    }

    #[On('updateCart')]
    public function render()
    {
        $authUser = auth('web')->user();
        $cart = $authUser->cart;

        $cart->load('items.product.images');
        return view('livewire.website.cart.cart-table', [
            'cartItems' => $cart->items,
        ]);
    }
}