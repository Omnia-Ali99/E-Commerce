<?php

namespace App\Services\Dashboard;

use App\Repositories\Dashboard\WorldRepository;

class WorldService
{

    protected $worldRepository;
    public function __construct(WorldRepository $worldRepository)
    {
        $this->worldRepository = $worldRepository;
    }

    public function getCountryById($id)
    {
        $country = $this->worldRepository->getCountryById($id);
        if(!$country){
            abort(404);
        }
        return $country;
    }
    public function getGovernorateById($id)
    {
        $governorate = $this->worldRepository->getGovernorateById($id);
        if(!$governorate){
            abort(404);
        }
        return $governorate;
    }

    public function getAllCountries()
    {
        return $this->worldRepository->getAllCountries();
    }

    public function getAllGovernorates($id)
    {
        $country = self::getCountryById($id);
        return $this->worldRepository->getAllGovernorates($country);
    }


    public function getAllCities($governorate_id)
    {
        $governorate = self::getGovernorateById($governorate_id);
        return $this->worldRepository->getAllCities($governorate);
    }


    public function changeStatus($country_id)
    {
        $country = self::getCountryById($country_id);
        $country = $this->worldRepository->changeStatus($country);

        if(!$country){
            return false;
        }
        return true;
    }
    public function changeGovStatus($gov_id)
    {
        $gov = self::getGovernorateById($gov_id);
        $gov = $this->worldRepository->changeStatus($gov);

        if(!$gov){
            return false;
        }
        return true;
    }

    public function changeShippingPrice($request)
    {
        $governorate = self::getGovernorateById($request->gov_id);
        $governorate = $this->worldRepository->changeShippingPrice($governorate,$request->price);

        if(!$governorate){
            return false;
        }
        return true;
    }
}
