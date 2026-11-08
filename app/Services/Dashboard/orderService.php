<?php

namespace App\Services\Dashboard;

use App\Repositories\Dashboard\OrderRepository;
use Yajra\DataTables\Facades\DataTables;

class OrderService
{
    /**
     * Create a new class instance.
     */
    protected $orderRepository;
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getAllOrdersForDatatables($request)
    {
        $ordersQuery = $this->orderRepository->getOrders();

        if ($request->has('status') && $request->status != '') {
            $ordersQuery->where('status', $request->status);
        }

        return DataTables::of($ordersQuery)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                return $row->status;
            })
            ->addColumn('coupon', function ($row) {
                return $row->coupon ?? __('dashboard.no_coupon');
            })
            ->addColumn('action', function ($row) {
                return view('dashboard.orders.datatables.action', compact('row'));
            })
            ->make(true);
    }

    public function deleteOrder($id)
    {
        $order = $this->orderRepository->getOrder($id);
        if (!$order)
            return false;

        if ($order->status == 'delivered' || $order->status == 'cancelled') {
            return $this->orderRepository->deleteOrder($order);
        }
        return false;
    }

    public function getOrderWithItems($id)
    {
        $order = $this->orderRepository->getOrderWithItemsById($id);
        if (!$order)
            return false;

        return $order;
    }

    public function markOrderAsDelivered($id)
    {
        $order = $this->orderRepository->getOrder($id);
        if (!$order)
            return false;

        return $this->orderRepository->markOrderAsDelivered($order);
    }
}