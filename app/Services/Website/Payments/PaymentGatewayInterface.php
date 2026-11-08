<?php

namespace App\Services\Website\Payments;

use App\Models\Order;

interface PaymentGatewayInterface
{
    public function key(): string;

    public function createCheckout(Order $order, array $shipping): PaymentRedirect;
}