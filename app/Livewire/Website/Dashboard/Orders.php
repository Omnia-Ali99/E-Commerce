<?php

namespace App\Livewire\Website\Dashboard;

use Livewire\Component;
use Livewire\Attributes\On;

class Orders extends Component
{
    public $screen = 'dashboard';
    public $auth_user;
    public $expandedOrderId = null;


    public function mount($auth_user)
    {
        $this->auth_user = $auth_user->load('orders.orderItems');
    }

    #[On('ordersSelectScreen')]
    public function selectScreen($screen)
    {
        $this->screen = $screen;
    }
    public function toggleOrderItems($orderId)
    {
        $this->expandedOrderId = $this->expandedOrderId === $orderId ? null : $orderId;
    }
    public function render()
    {
        return view('livewire.website.dashboard.orders');
    }
}