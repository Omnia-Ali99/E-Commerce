<?php

namespace App\Services\Website\Payments;

use App\Models\Order;
use RuntimeException;
use Stripe\StripeClient;

class StripePaymentGateway implements PaymentGatewayInterface
{
    public function key(): string
    {
        return 'stripe';
    }

    public function createCheckout(Order $order, array $shipping): PaymentRedirect
    {
        $secret = config('services.stripe.secret');

        if (! $secret) {
            throw new RuntimeException('Stripe secret key is not configured.');
        }

        $stripe = new StripeClient([
            'api_key' => $secret,
            'stripe_version' => '2026-02-25.clover',
        ]);

        $session = $stripe->checkout->sessions->create([
            'mode' => 'payment',
            'client_reference_id' => (string) $order->id,
            'customer_email' => $shipping['user_email'],
            'locale' => app()->getLocale() === 'ar' ? 'ar' : 'en',
            'line_items' => [[
                'quantity' => 1,
                'price_data' => [
                    'currency' => config('services.stripe.currency', 'egp'),
                    'unit_amount' => $this->toMinorUnits($order->total_price),
                    'product_data' => [
                        'name' => __('website.order') . ' #' . $order->id,
                    ],
                ],
            ]],
            'metadata' => [
                'order_id' => (string) $order->id,
                'user_id' => (string) $order->user_id,
                'gateway' => $this->key(),
            ],
            'success_url' => route('website.checkout.stripe.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('website.checkout.stripe.cancel', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
        ]);

        if (! $session->url || ! $session->id) {
            throw new RuntimeException('Stripe checkout session creation failed.');
        }

        return new PaymentRedirect($session->url, $session->id, $session->toArray());
    }

    private function toMinorUnits(float|int|string $amount): int
    {
        return (int) round(((float) $amount) * 100);
    }
}