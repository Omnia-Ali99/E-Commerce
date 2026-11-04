@extends('layouts.website.app')

@section('title', __('website.payment'))

@section('content')
    {{-- breadcrumb and header --}}
    <section class="blog about-blog">
        <div class="container">
            <div class="blog-bradcrum">
                <span><a href="{{ route('website.home') }}">{{ __('website.home') }}</a></span>
                <span class="devider">/</span>
                <span><a href="javascript:void(0)">{{ __('website.payment') }}</a></span>
            </div>
            <div class="blog-heading about-heading">
                <h1 class="heading">{{ __('website.payment') }}</h1>
            </div>
        </div>
    </section>

    <section class="checkout product footer-padding customer-checkout-page">
        <div class="container">
            <div class="checkout-section">
                <div class="row gy-4 align-items-start">
                    {{-- shipping address --}}
                    <div class="col-lg-7">
                        @livewire('website.checkout.shipping-details')
                    </div>
                    {{-- cart details --}}
                    <div class="col-lg-5">
                        @livewire('website.checkout.order-summary')
                        {{-- coupons --}}
                        <div class="customer-checkout-coupon">
                           @livewire('website.checkout.coupons')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection