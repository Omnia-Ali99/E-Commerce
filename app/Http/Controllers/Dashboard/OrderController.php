<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Services\Dashboard\OrderService;

class OrderController extends Controller
{
    public $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    public function index()
    {
        return view('dashboard.orders.index');
    }

    public function getAll(Request $request)
    {
        return $this->orderService->getAllOrdersForDatatables($request);
    }

    public function show($id)
    {
        $orderWithItems = $this->orderService->getOrderWithItems($id);
        if (!$orderWithItems) {
            Session::flash('error', 'Order not found');
            return redirect()->route('dashboard.orders.index');
        }

        return view('dashboard.orders.show', compact('orderWithItems'));
    }

    public function markDelivered($id)
    {
        $order = $this->orderService->markOrderAsDelivered($id);

        if (!$order) {
            Session::flash('error', 'Order Can Not Marked As Delivered');
            return redirect()->back();
        }
        Session::flash('success', 'Order Marked As Delivered Successfully');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $order = $this->orderService->deleteOrder($id);

        if (!request()->expectsJson()) {
            if (!$order) {
                Session::flash('error', 'Order Can Not Deleted');
                return  redirect()->back();
            }
            Session::flash('success', 'Order Deleted Successfully');
            return  redirect()->route('dashboard.orders.index');
        }

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Can Not Delete Order',
            ], 200);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Order Deleted Successfully',
        ], 200);
    }
}