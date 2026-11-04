<div>
    @php
        $enabledPaymentGateways = config('services.payment.enabled_gateways', ['stripe', 'myfatoorah', 'paymob']);
        $defaultPaymentGateway = old('payment_gateway', config('services.payment.default_gateway', 'stripe'));

        if (! in_array($defaultPaymentGateway, $enabledPaymentGateways, true)) {
            $defaultPaymentGateway = $enabledPaymentGateways[0] ?? 'stripe';
        }

        $gatewayMethods = config('services.payment.gateway_methods', []);
        $paymentGatewayCards = [
            'stripe' => [
                'title' => 'Stripe',
                'badge' => __('website.recommended'),
                'hint' => __('website.stripe_payment_hint'),
            ],
            'myfatoorah' => [
                'title' => 'MyFatoorah',
                'badge' => __('website.available'),
                'hint' => __('website.myfatoorah_payment_hint'),
            ],
            'paymob' => [
                'title' => 'Paymob',
                'badge' => __('website.available'),
                'hint' => __('website.paymob_payment_hint'),
            ],
        ];
    @endphp

    <form action="{{ route('website.checkout.post') }}" method="post" class="customer-checkout-form">
        @csrf
        <div class="customer-checkout-card">
            <div class="customer-checkout-card__header">
                <span class="customer-checkout-step">1</span>
                <div>
                    <h5>{{ __('website.shipping_address') }}</h5>
                    <p>{{ __('website.secure_payment_content') }}</p>
                </div>
            </div>

            <div class="customer-checkout-fields">
                <div class="customer-field">
                    <label for="checkout_first_name">{{ __('website.first_name') }}*</label>
                    <input name="first_name" type="text" id="checkout_first_name" class="form-control"
                        value="{{ old('first_name', auth('web')->user()?->name) }}"
                        placeholder="{{ __('website.first_name') }}">
                    @error('first_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="customer-field">
                    <label for="checkout_last_name">{{ __('website.last_name') }}*</label>
                    <input name="last_name" type="text" id="checkout_last_name" class="form-control"
                        value="{{ old('last_name') }}"
                        placeholder="{{ __('website.last_name') }}">
                    @error('last_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="customer-field">
                    <label for="checkout_email">{{ __('website.email') }}*</label>
                    <input name="user_email" type="email" id="checkout_email" class="form-control"
                        value="{{ old('user_email', auth('web')->user()?->email) }}"
                        placeholder="user@gmail.com">
                    @error('user_email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="customer-field">
                    <label for="checkout_phone">{{ __('website.phone') }}*</label>
                    <input name="user_phone" type="tel" id="checkout_phone" class="form-control"
                        value="{{ old('user_phone', auth('web')->user()?->phone) }}"
                        placeholder="+201000000000">
                    @error('user_phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="customer-field">
                    <label for="country_id">{{ __('website.country') }}*</label>
                    <select name="country_id" wire:model.live="countryId" class="form-control" id="country_id">
                        <option value="">{{ __('website.select_country') }}</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                    @error('country_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="customer-field">
                    <label for="governorate_id">{{ __('website.governorate') }}*</label>
                    <select name="governorate_id" wire:model.live="governorateId" class="form-control"
                        id="governorate_id">
                        <option value="">{{ __('website.select_governorate') }}</option>
                        @foreach ($governorates as $governorate)
                            <option value="{{ $governorate->id }}">{{ $governorate->name }}</option>
                        @endforeach
                    </select>
                    @error('governorate_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="customer-field">
                    <label for="city_id">{{ __('website.city') }}*</label>
                    <select name="city_id" wire:model="cityId" class="form-control" id="city_id">
                        <option value="">{{ __('website.select_city') }}</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                    @error('city_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="customer-field">
                    <label for="checkout_street">{{ __('website.street_name') }}*</label>
                    <input name="street" type="text" id="checkout_street" class="form-control"
                        value="{{ old('street') }}"
                        placeholder="{{ __('website.street_name') }}">
                    @error('street')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="customer-field customer-field--wide">
                    <label for="checkout_note">{{ __('website.notice') }}*</label>
                    <textarea name="note" id="checkout_note" class="form-control" rows="4"
                        placeholder="{{ __('website.notice') }}">{{ old('note') }}</textarea>
                    @error('note')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="customer-payment-methods">
                <div class="customer-payment-methods__header">
                    <span class="customer-checkout-step">2</span>
                    <div>
                        <h5>{{ __('website.payment_method') }}</h5>
                        <p>{{ __('website.payment_method_hint') }}</p>
                    </div>
                </div>

                <div class="customer-payment-options">
                    @foreach ($paymentGatewayCards as $gatewayKey => $gateway)
                        @continue(! in_array($gatewayKey, $enabledPaymentGateways, true))
                        <label class="customer-payment-option">
                            <span class="customer-payment-option__content">
                                <span class="customer-payment-option__top">
                                    <span class="customer-payment-option__brand">
                                        <input type="radio" name="payment_gateway" value="{{ $gatewayKey }}"
                                            @checked($defaultPaymentGateway === $gatewayKey)>
                                        <strong>{{ $gateway['title'] }}</strong>
                                    </span>
                                    <em>{{ $gateway['badge'] }}</em>
                                </span>
                                <span class="customer-payment-option__desc">
                                    {{ $gateway['hint'] }}
                                </span>
                                <span class="customer-payment-method-list">
                                    @foreach (($gatewayMethods[$gatewayKey] ?? ['cards']) as $method)
                                        @php
                                            $methodLabelKey = 'website.payment_method_' . $method;
                                            $methodLabel = __($methodLabelKey);
                                            $methodLabel = $methodLabel === $methodLabelKey
                                                ? str($method)->replace('_', ' ')->title()
                                                : $methodLabel;
                                        @endphp
                                        <span>
                                            {{-- @include('website.partials.payment-method-icon', ['method' => $method]) --}}
                                            {{ $methodLabel }}
                                        </span>
                                    @endforeach
                                </span>
                            </span>
                        </label>
                    @endforeach
                </div>

                @error('payment_gateway')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="shop-btn customer-checkout-submit">
                {{ __('website.place_order_now') }}
            </button>
        </div>
    </form>
</div>