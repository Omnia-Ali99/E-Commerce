<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Services\Dashboard\CouponService;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $couponService;
    public function __construct(CouponService $couponService)
    {
        $this->couponService = $couponService;
    }
    public function index()
    {
        return view('dashboard.coupons.index');
    }

    public function getAll()
    {
        return $this->couponService->getCouponsForDatatables();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CouponRequest $request)
    {
        $data = $request->except(['_token']);
        $coupon =  $this->couponService->createCoupon($data);
        if (!$coupon) {
            return response()->json([
                'status' => 'error',
                'message' => __('dashboard.error_msg'),
            ], 500);
        }
        return response()->json([
            'status' => 'success',
            'message' => __('dashboard.success_msg')
        ], 201);
    }


    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CouponRequest $request, string $id)
    {
        $data = $request->except(['_token']);
        $coupon =  $this->couponService->updateCoupon($id , $data);
        if (!$coupon) {
            return response()->json([
                'status' => 'error',
                'message' => __('dashboard.error_msg'),
            ], 500);
        }
        return response()->json([
            'status' => 'success',
            'message' => __('dashboard.success_msg')
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!$this->couponService->deleteCoupon($id)) {
            return response()->json([
                'status' => 'error',
                'message' => __('dashboard.error_msg'),
            ], 500);
        }
        return response()->json([
            'status' => 'success',
            'message' => __('dashboard.success_msg')
        ], 200);
    }
}