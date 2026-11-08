<?php

namespace App\Livewire\Website\Dashboard;

use Livewire\Component;
use Livewire\Attributes\On;

class Address extends Component
{
    public $screen = 'dashboard';
    public $auth_user ;

    public function mount($auth_user)
    {
        $this->auth_user = $auth_user;
    }

    #[On('addressSelectScreen')]
    public function selectScreen($screen)
    {
        $this->screen = $screen;
    }
    public function render()
    {
        return view('livewire.website.dashboard.address');
    }
}