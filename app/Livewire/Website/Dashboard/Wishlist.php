<?php

namespace App\Livewire\Website\Dashboard;

use Livewire\Component;
use Livewire\Attributes\On;

class Wishlist extends Component
{
    public $screen = 'dashboard';

    #[On('wishlistSelectScreen')]
    public function selectScreen($screen)
    {
        $this->screen = $screen;
    }
    public function render()
    {
        return view('livewire.website.dashboard.wishlist');
    }
}