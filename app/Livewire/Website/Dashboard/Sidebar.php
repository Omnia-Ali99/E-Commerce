<?php

namespace App\Livewire\Website\Dashboard;

use Livewire\Component;
use Livewire\Attributes\On;

class Sidebar extends Component
{
    public $screen = 'dashboard';

    public function selectScreen($screen)
    {
        // address
        $this->screen = $screen;
        // tell the all dashboard component to update the screen
        $this->dispatch('dashboardSelectScreen', $screen);
        $this->dispatch('ordersSelectScreen', $screen);
        $this->dispatch('passwordSelectScreen', $screen);
        $this->dispatch('personalSelectScreen', $screen);
        $this->dispatch('addressSelectScreen', $screen);
        $this->dispatch('wishlistSelectScreen', $screen);
        $this->dispatch('reviewSelectScreen', $screen);
    }

    public function render()
    {
        return view('livewire.website.dashboard.sidebar');
    }
}