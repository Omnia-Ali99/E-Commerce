<?php

namespace App\Services\Website\Payments;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class PaymobPaymentGateway implements PaymentGatewayInterface
{
    public function key(): string
    {
        return 'paymob';
    }

    public function createCheckout(Order $order, array $shipping): PaymentRedirect
    {
        $secretKey = config('services.paymob.secret_key');
        $publicKey = config('services.paymob.public_key');
        $integrationIds = config('services.paymob.integration_ids', []);

        if (! $secretKey || ! $publicKey || empty($integrationIds)) {
            throw new RuntimeException('Paymob credentials or integration IDs are not configured.');
        }

        $response = Http::withHeaders([
                'Authorization' => 'Token ' . $secretKey,
            ])
            ->acceptJson()
            ->post($this->endpoint('/v1/intention/'), [
                'amount' => $this->toMinorUnits($order->total_price),
                'currency' => config('services.paymob.currency', 'EGP'),
                'payment_methods' => $integrationIds,
                'special_reference' => 'order_' . $order->id,
                'billing_data' => $this->billingData($shipping),
                'items' => $this->items($order),
                'extras' => [
                    'order_id' => (string) $order->id,
                    'user_id' => (string) $order->user_id,
                    'gateway' => $this->key(),
                ],
                'notification_url' => route('website.checkout.paymob.webhook', [], true),
                'redirection_url' => route('website.checkout.paymob.callback', [], true),
            ]);

        if (! $response->successful()) {
            throw new RuntimeException('Paymob intention creation failed: ' . $response->body());
        }

        $payload = $response->json();
        $clientSecret = data_get($payload, 'client_secret');
        $reference = 'order_' . $order->id;

        if (! $clientSecret) {
            throw new RuntimeException('Paymob intention response is missing checkout data.');
        }

        $url = $this->endpoint('/unifiedcheckout/') . '?' . http_build_query([
            'publicKey' => $publicKey,
            'clientSecret' => $clientSecret,
        ]);

        return new PaymentRedirect($url, (string) $reference, $payload);
    }

    private function endpoint(string $path): string
    {
        return config('services.paymob.base_url', 'https://accept.paymob.com') . $path;
    }

    private function billingData(array $shipping): array
    {
        return [
            'first_name' => $shipping['first_name'],
            'last_name' => $shipping['last_name'],
            'email' => $shipping['user_email'],
            'phone_number' => $shipping['user_phone'],
            'street' => $shipping['street'],
            'building' => 'NA',
            'floor' => 'NA',
            'apartment' => 'NA',
            'city' => (string) $shipping['city_id'],
            'country' => config('services.paymob.billing_country', 'EGY'),
        ];
    }

    private function items(Order $order): array
    {
        return $order->orderItems->map(fn ($item) => [
            'name' => $item->product_name,
            'amount' => $this->toMinorUnits($item->product_price),
            'quantity' => (int) $item->product_quantity,
        ])->values()->all();
    }

    private function toMinorUnits(float|int|string $amount): int
    {
        return (int) round(((float) $amount) * 100);
    }
}