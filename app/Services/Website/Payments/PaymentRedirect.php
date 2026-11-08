<?php

namespace App\Services\Website\Payments;

class PaymentRedirect
{
    public function __construct(
        public readonly string $url,
        public readonly string $reference,
        public readonly array $payload = [],
    ) {
    }
}