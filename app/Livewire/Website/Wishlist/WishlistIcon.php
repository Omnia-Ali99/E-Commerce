<?php

namespace App\Livewire\Website\Wishlist;

use Livewire\Component;
use Livewire\Attributes\On;

class WishlistIcon extends Component
{
    #[On('wishlistCountRefresh')]
    public function render()
    {
        $count = auth('web')->check() ? auth('web')->user()->wishlists()->get()->count() : 0;
        return view('livewire.website.wishlist.wishlist-icon',[
            'wishlistsCount' => $count,
        ]);
    }
}