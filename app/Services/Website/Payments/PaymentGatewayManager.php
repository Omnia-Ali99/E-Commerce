<?php

namespace App\Services\Website\Payments;

use InvalidArgumentException;

class PaymentGatewayManager
{
    public function __construct(
        private readonly StripePaymentGateway $stripe,
        private readonly MyFatoorahPaymentGateway $myFatoorah,
        private readonly PaymobPaymentGateway $paymob,
    ) {
    }

    public function defaultGateway(): string
    {
        return config('services.payment.default_gateway', 'stripe');
    }

    public function enabledGateways(): array
    {
        $gateways = config('services.payment.enabled_gateways', ['stripe', 'myfatoorah', 'paymob']);

        return array_values(array_intersect($gateways, array_keys($this->gateways())));
    }

    public function isEnabled(string $gateway): bool
    {
        return in_array($gateway, $this->enabledGateways(), true);
    }

    public function get(?string $gateway = null): PaymentGatewayInterface
    {
        $gateway = $gateway ?: $this->defaultGateway();

        if (! $this->isEnabled($gateway)) {
            throw new InvalidArgumentException("Payment gateway [$gateway] is not enabled.");
        }

        return $this->gateways()[$gateway];
    }

    private function gateways(): array
    {
        return [
            $this->stripe->key() => $this->stripe,
            $this->myFatoorah->key() => $this->myFatoorah,
            $this->paymob->key() => $this->paymob,
        ];
    }
}