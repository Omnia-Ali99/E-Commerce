<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderShippingRequest;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
        public function showCheckoutPage()
    {
        return view('website.checkout');
    }

     public function checkout(OrderShippingRequest $request)
    {
        $shipping = $request->validated();
        $gatewayKey = $shipping['payment_gateway'] ?? $this->paymentGateways->defaultGateway();

        $invoiceValue = $this->orderService->getInvoiceValue($shipping);
        if ($invoiceValue < 1 || $invoiceValue === null) {
            return redirect()->back()->with('error', __('website.cart_empty'));
        }

        try {
            $gateway = $this->paymentGateways->get($gatewayKey);
            $order = $this->orderService->createOrder($shipping);

            if (! $order) {
                Session::flash('error', __('website.something_went_wrong'));
                return redirect()->route('website.checkout.get');
            }

            $redirect = $gateway->createCheckout($order, $shipping);
            $transaction = $this->orderService->createTransactionForGateway(
                $gateway->key(),
                $redirect->reference,
                $order->id
            );

            if (! $transaction) {
                Session::flash('error', __('website.something_went_wrong'));
                return redirect()->route('website.checkout.get');
            }

            return redirect($redirect->url);
        } catch (Throwable $exception) {
            report($exception);
            Session::flash('error', __('website.something_went_wrong'));
            return redirect()->route('website.checkout.get');
        }
    }

}
