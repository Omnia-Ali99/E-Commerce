<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Dashboard\WorldService;
use App\Http\Requests\shippingPriceRequest;

class WorldController extends Controller
{
    protected $worldService;
    public function __construct(WorldService $worldService)
    {
        $this->worldService = $worldService;
    }


    public function getAllCountries()
    {
        $countries =  $this->worldService->getAllCountries();
        return view('dashboard.world.countries', compact('countries'));
    }

    public function getGovsByCountry($id)
    {
        $governorates =  $this->worldService->getAllGovernorates($id);
        return view('dashboard.world.governorates', compact('governorates'));
    }

    public function getCitiesByGovId($id)
    {
        $cities =  $this->worldService->getAllCities($id);
        return view('dashboard.world.cities', compact('cities'));
    }



    public function changeStatus($country_id)
    {
        $country = $this->worldService->changeStatus($country_id);
        if (!$country) {
            return response()->json([
                'status' => false,
                'message' => __('dashboard.error_msg')
            ], 404);
        }
        $country = $this->worldService->getCountryById($country_id);
        return response()->json([
            'status' => 'success',
            'message' => __('dashboard.success_msg'),
            'data' => $country
        ], 200);
    }


    public function changeGovStatus($gov_id)
    {
        $gov = $this->worldService->changeGovStatus($gov_id);
        if (!$gov) {
            return response()->json([
                'status' => false,
                'message' => __('dashboard.error_msg')
            ], 404);
        }

        $gov = $this->worldService->getGovernorateById($gov_id);
        return response()->json([
            'status' => 'success',
            'message' => __('dashboard.success_msg'),
            'data' => $gov
        ], 200);
    }

    public function changeShippingPrice(shippingPriceRequest $request)
    {
        if (!$this->worldService->changeShippingPrice($request)) {
            return response()->json([
                'status' => false,
                'message' => __('dashboard.error_msg')
            ], 404);
        }

        $gov = $this->worldService->getGovernorateById($request->gov_id);

        $gov->load('shippingPrice');
        return response()->json([
            'status' => 'success',
            'message' => __('dashboard.success_msg'),
            'data' => $gov
        ], 200);
    }
}
