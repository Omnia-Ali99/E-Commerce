<?php

namespace App\Livewire\Website\Dashboard;

use App\Models\City;
use App\Models\Country;
use Livewire\Component;
use App\Models\Governorate;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ProfileInfo extends Component
{
    use WithFileUploads;

    public $screen = 'dashboard';

    public $name , $email , $phone ;
    public $country_id,$governorate_id,$city_id;
    public $image;
    public $auth_user;
    public function mount($auth_user)
    {
        $this->auth_user = $auth_user;
        $this->name = $auth_user->name;
        $this->email = $auth_user->email;
        $this->phone = $auth_user->phone;
        $this->country_id = $auth_user->country->id;
        $this->governorate_id = $auth_user->governorate->id;
        $this->city_id = $auth_user->city->id;
    }

    #[On('personalSelectScreen')]
    public function selectScreen($screen)
    {
        $this->screen = $screen;
    }

    public function updated($property)
    {
        if ($property === 'country_id') {
            $this->reset(['governorate_id', 'city_id']);
        }

        if ($property === 'governorate_id') {
            $this->reset('city_id');
        }
    }

    public function updatedCountryId()
    {
        $this->reset(['governorate_id', 'city_id']);
    }

    public function updatedGovernorateId()
    {
        $this->reset('city_id');
    }

    protected function rules()
    {
        return[
            'name' => 'required|string|max:255',
            'email'=> 'required|email|max:255',
            'phone'=> 'required|numeric',
            'country_id' => 'required|exists:countries,id',
            'governorate_id' => 'required|exists:governorates,id',
            'city_id' => 'required|exists:cities,id',
            'image' => 'nullable|image|max:5120',
        ];
    }

    public function updateProfile()
    {
        $this->validate();
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'country_id' => $this->country_id,
            'governorate_id' => $this->governorate_id,
            'city_id' => $this->city_id,
        ];

        if ($this->image) {
            if ($this->auth_user->image) {
                Storage::disk('users')->delete($this->auth_user->image);
            }

            $data['image'] = $this->image->store('', 'users');
        }

        $this->auth_user->update($data);
        $this->auth_user->refresh();
        $this->reset('image');

        $this->dispatch('profileUpdated', __('website.profile_updated_successfully'));
    }
    public function render()
    {
        return view('livewire.website.dashboard.profile-info',[
              'countries'    => Country::get(),
              'governorates' => $this->country_id ? Governorate::where('country_id', $this->country_id)->get() : [],
              'cities'       => $this->governorate_id ? City::where('governorate_id', $this->governorate_id)->get() : [],
        ]);
    }
}