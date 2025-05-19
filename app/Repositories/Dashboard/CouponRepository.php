<?php

namespace App\Repositories\Dashboard;

use App\Models\Coupon;

class CouponRepository
{

    public function getCoupon($id)
    {
        return Coupon::find($id);
    }
    public function getCoupons()
    {
        return Coupon::latest()->get();
    }
    public function createCoupon($data)
    {
        return Coupon::create($data);
    }
    public function updateCoupon($coupon, $data)
    {
        return $coupon->update($data);
    }
    public function deleteCoupon($coupon)
    {
        return $coupon->delete();
    }

}