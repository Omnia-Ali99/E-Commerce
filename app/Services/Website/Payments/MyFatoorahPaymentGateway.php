<?php

namespace App\Services\Website\Payments;

use App\Models\Order;
use App\Services\Website\MyFatoorahService;
use RuntimeException;

class MyFatoorahPaymentGateway implements PaymentGatewayInterface
{
    public function __construct(private readonly MyFatoorahService $myFatoorahService)
    {
    }

    public function key(): string
    {
        return 'myfatoorah';
    }

    public function createCheckout(Order $order, array $shipping): PaymentRedirect
    {
        $response = $this->myFatoorahService->checkout([
            'CustomerName' => $shipping['first_name'] . ' ' . $shipping['last_name'],
            'NotificationOption' => 'LNK',
            'InvoiceValue' => $order->total_price,
            'DisplayCurrencyIso' => 'EGP',
            'CustomerEmail' => $shipping['user_email'],
            'CallBackUrl' => route('website.checkout.myfatoorah.callback', [], true),
            'ErrorUrl' => route('website.checkout.myfatoorah.error', [], true),
            'Language' => app()->getLocale() === 'ar' ? 'ar' : 'en',
        ]);

        $url = is_array($response) ? data_get($response, 'Data.InvoiceURL') : null;
        $invoiceId = is_array($response) ? data_get($response, 'Data.InvoiceId') : null;

        if (! $url || ! $invoiceId) {
            throw new RuntimeException('MyFatoorah checkout failed.');
        }

        return new PaymentRedirect($url, (string) $invoiceId, $response);
    }
}