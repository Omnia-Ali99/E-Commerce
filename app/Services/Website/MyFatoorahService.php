<?php

namespace App\Services\Website;
use Illuminate\Support\Facades\Http;

class MyFatoorahService
{
    private $base_url, $headers;

    public function __construct()
    {
        $this->base_url = env('payment_base_url');
        $this->headers = [
            'Authorization' => 'Bearer ' . env('payment_token'),
        ];
    }

    public function createRequest($uri, $method, $body = [])
    {
        if (empty($body)) {
            return false;
        }

        $response = Http::withHeaders($this->headers)
            ->withoutVerifying() // equivalent to 'verify' => false
            ->acceptJson()       // sets Content-Type and Accept headers to JSON
            ->timeout(30)        // optional: in seconds
            ->send($method, $this->base_url . $uri, [
                'json' => $body,
            ]);

        if (!$response->successful()) {
            return false;
        }

        return $response->json();
    }

    public function checkout($data)
    {
        return $this->createRequest('v2/SendPayment', 'POST', $data);
    }

    public function getPaymentStatus($data)
    {
        return $this->createRequest('v2/getPaymentStatus', 'POST', $data);
    }
}