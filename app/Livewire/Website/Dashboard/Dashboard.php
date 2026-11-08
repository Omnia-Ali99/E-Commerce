<?php

namespace App\Livewire\Website\Dashboard;

use Livewire\Component;
use Livewire\Attributes\On;

class Dashboard extends Component
{
    public $screen = 'dashboard';

    public $auth_user;
    public $new_orders_count;
    public $delivered_orders_count;
    public function mount($auth_user ,$new_orders_count,$delivered_orders_count)
    {
        $this->auth_user = $auth_user;
        $this->new_orders_count = $new_orders_count;
        $this->delivered_orders_count = $delivered_orders_count;
    }

    #[On('dashboardSelectScreen')]
    public function selectScreen($screen)
    {
        $this->screen = $screen;
    }
    public function render()
    {
        return view('livewire.website.dashboard.dashboard');
    }
}