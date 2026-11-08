<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderShippingRequest;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Transaction;
use App\Notifications\CreateOrderNotification;
use App\Services\Website\MyFatoorahService;
use App\Services\Website\OrderService;
use App\Services\Website\Payments\PaymentGatewayManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Stripe\Exception\SignatureVerificationException;
use Stripe\StripeClient;
use Stripe\Webhook;
use Throwable;

class CheckoutController extends Controller
{
    public function __construct(
        protected OrderService $orderService,
        protected MyFatoorahService $myFatoorahService,
        protected PaymentGatewayManager $paymentGateways,
    ) {
    }

    public function showCheckoutPage()
    {
        return view('website.checkout', [
            'enabledPaymentGateways' => $this->paymentGateways->enabledGateways(),
            'defaultPaymentGateway' => $this->paymentGateways->defaultGateway(),
        ]);
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

    public function paymentCallback(Request $request)
    {
        $response = $this->myFatoorahService->getPaymentStatus([
            'key' => $request->paymentId,
            'KeyType' => 'paymentId',
        ]);

        $invoiceId = is_array($response) ? data_get($response, 'Data.InvoiceId') : null;
        $invoiceStatus = is_array($response) ? data_get($response, 'Data.InvoiceStatus') : null;

        if (! $invoiceId || ! $invoiceStatus) {
            Session::flash('error', __('website.something_went_wrong'));
            return redirect()->route('website.checkout.get');
        }

        if ($invoiceStatus === 'Paid') {
            $this->markTransactionPaid((string) $invoiceId);
            Session::flash('success', __('website.payment_success'));
            return redirect()->route('website.checkout.get');
        }

        Session::flash('error', __('website.payment_failed'));
        return redirect()->route('website.checkout.get');
    }

    public function paymentError()
    {
        Session::flash('error', __('website.payment_failed'));
        return redirect()->route('website.checkout.get');
    }

    public function stripeSuccess(Request $request)
    {
        $sessionId = $request->query('session_id');

        if (! $sessionId) {
            Session::flash('error', __('website.something_went_wrong'));
            return redirect()->route('website.checkout.get');
        }

        try {
            $session = $this->stripe()->checkout->sessions->retrieve($sessionId);

            if ($session->payment_status === 'paid') {
                $this->markTransactionPaid($session->id);
                Session::flash('success', __('website.payment_success'));
            } else {
                Session::flash('success', __('website.payment_pending'));
            }
        } catch (Throwable $exception) {
            report($exception);
            Session::flash('error', __('website.something_went_wrong'));
        }

        return redirect()->route('website.checkout.get');
    }

    public function stripeCancel()
    {
        Session::flash('error', __('website.payment_cancelled'));
        return redirect()->route('website.checkout.get');
    }

    public function stripeWebhook(Request $request)
    {
        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        if (! $secret) {
            Log::error('Stripe webhook secret is not configured.');
            return response()->json(['message' => 'Webhook secret is not configured'], 500);
        }

        try {
            $event = Webhook::constructEvent($payload, $signature, $secret);
        } catch (SignatureVerificationException $exception) {
            Log::warning('Invalid Stripe webhook signature.', ['message' => $exception->getMessage()]);
            return response()->json(['message' => 'Invalid signature'], 400);
        } catch (Throwable $exception) {
            Log::warning('Invalid Stripe webhook payload.', ['message' => $exception->getMessage()]);
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        if (($event->type ?? null) === 'checkout.session.completed') {
            $session = $event->data->object ?? null;

            if (($session->payment_status ?? null) === 'paid' && isset($session->id)) {
                $this->markTransactionPaid($session->id);
            }
        }

        return response()->json(['received' => true]);
    }

    public function paymobCallback(Request $request)
    {
        $payload = $request->all();

        if (! $this->paymobSignatureIsValid($payload)) {
            Session::flash('error', __('website.payment_failed'));
            return redirect()->route('website.checkout.get');
        }

        if ($this->paymobPaymentSucceeded($payload)) {
            $order = $this->markPaymobOrderPaid($payload);

            if ($order) {
                Session::flash('success', __('website.payment_success'));
                return redirect()->route('website.checkout.get');
            }
        }

        Session::flash('error', __('website.payment_failed'));
        return redirect()->route('website.checkout.get');
    }

    public function paymobWebhook(Request $request)
    {
        $payload = $request->all();

        if (! $this->paymobSignatureIsValid($payload)) {
            Log::warning('Invalid Paymob webhook signature.', ['payload' => $payload]);
            return response()->json(['message' => 'Invalid signature'], 400);
        }

        if ($this->paymobPaymentSucceeded($payload)) {
            $this->markPaymobOrderPaid($payload);
        }

        return response()->json(['received' => true]);
    }

    private function stripe(): StripeClient
    {
        return new StripeClient([
            'api_key' => config('services.stripe.secret'),
            'stripe_version' => '2026-02-25.clover',
        ]);
    }

    private function markTransactionPaid(string $transactionId): ?Order
    {
        $transaction = Transaction::where('transaction_id', $transactionId)->first();

        if (! $transaction) {
            return null;
        }

        $order = Order::where('id', $transaction->order_id)
            ->where('user_id', $transaction->user_id)
            ->first();

        if (! $order) {
            return null;
        }

        if ($order->status !== 'paid') {
            $order->update(['status' => 'paid']);

            foreach (Admin::all() as $admin) {
                $admin->notify(new CreateOrderNotification($order));
            }
        }

        return $order;
    }

    private function markPaymobOrderPaid(array $payload): ?Order
    {
        $reference = $this->paymobReference($payload);

        if ($reference) {
            $order = $this->markTransactionPaid($reference);

            if ($order) {
                return $order;
            }
        }

        $orderId = $this->paymobOrderId($payload);

        if (! $orderId) {
            return null;
        }

        $transaction = Transaction::where('payment_method', 'paymob')
            ->where('order_id', $orderId)
            ->first();

        if (! $transaction) {
            return null;
        }

        return $this->markTransactionPaid($transaction->transaction_id);
    }

    private function paymobPaymentSucceeded(array $payload): bool
    {
        $success = data_get($payload, 'success', data_get($payload, 'obj.success'));
        $pending = data_get($payload, 'pending', data_get($payload, 'obj.pending'));

        return filter_var($success, FILTER_VALIDATE_BOOLEAN)
            && ! filter_var($pending, FILTER_VALIDATE_BOOLEAN);
    }

    private function paymobReference(array $payload): ?string
    {
        foreach ([
            'special_reference',
            'merchant_order_id',
            'obj.special_reference',
            'obj.merchant_order_id',
            'order.special_reference',
            'obj.order.special_reference',
        ] as $key) {
            $value = data_get($payload, $key);

            if (is_string($value) && $value !== '') {
                return $value;
            }
        }

        $orderId = $this->paymobOrderId($payload);

        return $orderId ? 'order_' . $orderId : null;
    }

    private function paymobOrderId(array $payload): ?int
    {
        foreach ([
            'extras.order_id',
            'obj.extras.order_id',
            'order_id',
            'obj.order_id',
        ] as $key) {
            $value = data_get($payload, $key);

            if (is_numeric($value)) {
                return (int) $value;
            }
        }

        foreach ([
            'special_reference',
            'merchant_order_id',
            'obj.special_reference',
            'obj.merchant_order_id',
        ] as $key) {
            $value = data_get($payload, $key);

            if (is_string($value) && preg_match('/^order_(\d+)$/', $value, $matches)) {
                return (int) $matches[1];
            }
        }

        return null;
    }

    private function paymobSignatureIsValid(array $payload): bool
    {
        $secret = config('services.paymob.hmac_secret');
        $hmac = data_get($payload, 'hmac');

        if (! $secret) {
            return true;
        }

        if (! $hmac) {
            return false;
        }

        return hash_equals(strtolower((string) $hmac), strtolower($this->paymobHmac($payload, $secret)));
    }

    private function paymobHmac(array $payload, string $secret): string
    {
        $data = data_get($payload, 'obj', $payload);
        $fields = [
            'amount_cents',
            'created_at',
            'currency',
            'error_occured',
            'has_parent_transaction',
            'id',
            'integration_id',
            'is_3d_secure',
            'is_auth',
            'is_capture',
            'is_refunded',
            'is_standalone_payment',
            'is_voided',
            'order.id',
            'owner',
            'pending',
            'source_data.pan',
            'source_data.sub_type',
            'source_data.type',
            'success',
        ];

        $message = collect($fields)
            ->map(fn ($field) => (string) data_get($data, $field, ''))
            ->implode('');

        return hash_hmac('sha512', $message, $secret);
    }
}