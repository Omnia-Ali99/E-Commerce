<?php

namespace App\Livewire\Website\Checkout;

use App\Models\City;
use App\Models\Country;
use Livewire\Component;
use App\Models\Governorate;
use App\Models\ShippingGovernorate;

class ShippingDetails extends Component
{
    public $countryId, $governorateId, $cityId;

    public function updatedCountryId()
    {
        $this->reset(['governorateId', 'cityId']);
        $this->dispatch('shippingPriceUpdated', 0);
    }

    public function updatedGovernorateId()
    {
        $this->reset('cityId');

        $price = ShippingGovernorate::where('governorate_id', $this->governorateId)->value('price') ?? 0;
        $this->dispatch('shippingPriceUpdated', $price);
    }

    public function render()
    {
        $countries = Country::where('is_active', 1)->get();
        if ($countries->isEmpty()) {
            $countries = Country::get();
        }

        $governorates = collect();
        if ($this->countryId) {
            $governorates = Governorate::where('country_id', $this->countryId)
                ->where('is_active', 1)
                ->get();
        }

        return view('livewire.website.checkout.shipping-details', [
            'countries'    => $countries,
            'governorates' => $governorates,
            'cities'       => $this->governorateId ? City::where('governorate_id', $this->governorateId)->get() : [],
        ]);
    }
}