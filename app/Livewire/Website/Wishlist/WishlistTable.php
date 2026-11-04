<?php

namespace App\Livewire\Website\Wishlist;

use Livewire\Component;
use App\Models\Wishlist as WishlistModel;

class WishlistTable extends Component
{

    public function removeFromWishlist($wishlistId)
    {
        $wishlist = WishlistModel::find($wishlistId);
        $wishlist->delete();

        $this->dispatch('wishlistCountRefresh');
    }

    public function clearWishlist()
    {
        auth('web')->user()->wishlists()->delete();
        $this->dispatch('wishlistCountRefresh');
    }
    public function render()
    {
        return view('livewire.website.wishlist.wishlist-table',[
            'wishlists' => auth('web')->user()->wishlists()->get(),
        ]);
    }
}