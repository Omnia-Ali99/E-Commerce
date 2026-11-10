<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Http\Resources\countryResource;
use App\Http\Resources\GovernorateResource;
use App\Models\Country;
use App\Models\Governorate;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class AddressController extends Controller
{
     use ApiResponse;

    public function getCountries()
    {
        $countries = Country::get();
        return $this->apiResponse([
            'countries' => CountryResource::collection($countries),
        ],true, 'Countries fetched successfully', 200);
    }

    public function getGovernorates($country_id)
    {
        $country = Country::find($country_id);
        $governorates = $country->governorates;
        return $this->apiResponse([
            'governorates' => GovernorateResource::collection($governorates),
        ], true,'Governorates fetched successfully', 200);
    }

    public function getCities($governorate_id)
    {
        $governorate = Governorate::find($governorate_id);
        $cities = $governorate->cities;
        return $this->apiResponse([
            'cities' => CityResource::collection($cities),
        ], true ,'Cities fetched successfully', 200);
    }
}
