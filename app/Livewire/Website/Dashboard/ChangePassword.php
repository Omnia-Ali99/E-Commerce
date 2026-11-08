<?php

namespace App\Livewire\Website\Dashboard;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Hash;

class ChangePassword extends Component
{
    public $screen = 'dashboard';

    public $old_password;
    public $password;
    public $password_confirmation;
    #[On('passwordSelectScreen')]
    public function selectScreen($screen)
    {
        $this->screen = $screen;
    }

    public function updatePassword()
    {
        // TODO: Implement updatePassword() method.
        $this->validate([
            'old_password' => 'required',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
        ]);
        if (Hash::check($this->old_password, auth('web')->user()->password)) {
            auth('web')->user()->update([
                'password' => bcrypt($this->password),
            ]);
            $this->dispatch('passwordChanged' , __('website.password_changed_successfully'));
            $this->reset('old_password','password','password_confirmation');
        } else {
            $this->dispatch('oldPasswordNotMatched' , __('website.old_password_not_matched'));
        }

    }
    public function render()
    {
        return view('livewire.website.dashboard.change-password');
    }
}