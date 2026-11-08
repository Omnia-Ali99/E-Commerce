<?php

namespace App\Repositories\Dashboard;

use App\Models\Order;

class OrderRepository
{

    public function getOrder($id)
    {
        // TODO: Implement getOrder() method.
        return Order::find($id);
    }
    public function getOrders()
    {
        // TODO: Implement getOrders() method.
        return Order::query()->latest();
    }

    public function markOrderAsDelivered($order)
    {
        // TODO: Implement changeOrderToDilivered() method.
        return $order->update(['status' => 'delivered']);
    }

    public function deleteOrder($order)
    {
        // TODO: Implement deleteOrder() method.
        return $order->delete();
    }
    public function getOrderWithItemsById($id)
    {
        // TODO: Implement getOrderWithItemsById() method.
        return Order::with('orderItems')->find($id);
    }
}