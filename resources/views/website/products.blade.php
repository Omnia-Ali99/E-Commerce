@extends('layouts.website.app')
@section('title', __('website.products'))

@php
    $flashTimer = $flash_timer ?? false;
@endphp

@section('content')
    @if ($products->count() > 0)
        <section class="product product-sidebar @if ($flashTimer) flash-sale @endif footer-padding customer-product-listing">
            <div class="container">
                <div class="product-sidebar-section" data-aos="fade-up">
                    <div class="row g-4">
                        @if ($flashTimer)
                            <div class="col-12">
                                <div class="countdown-section">
                                    <div class="countdown-items">
                                        <span id="day" class="number" style="color: red;">1</span>
                                        <span class="text">{{ __('website.days') }}</span>
                                    </div>
                                    <div class="countdown-items">
                                        <span id="hour" class="number" style="color: skyblue;">2</span>
                                        <span class="text">{{ __('website.hours') }}</span>
                                    </div>
                                    <div class="countdown-items">
                                        <span id="minute" class="number" style="color: green;">2</span>
                                        <span class="text">{{ __('website.minutes') }}</span>
                                    </div>
                                    <div class="countdown-items">
                                        <span id="second" class="number" style="color: red;">55</span>
                                        <span class="text">{{ __('website.seconds') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="col-12">
                            <div class="product-sorting-section customer-results-bar">
                                <div class="result">
                                    <p>{{ __('website.showing') }}
                                        <span>{{ $products->firstItem() }}-{{ $products->lastItem() }}
                                            {{ __('website.of') }} {{ $products->total() }}
                                            {{ __('website.results') }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        @foreach ($products as $item)
                            <div class="col-xl-3 col-lg-4 col-sm-6">
                                @include('website.partials.product-card', [
                                    'product' => $item,
                                    'context' => 'products-' . $loop->iteration,
                                ])
                            </div>
                        @endforeach

                        <div class="col-12">
                            <div class="customer-pagination">
                                {{-- {{ $products->links('website.partials.pagination') }} --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section class="blog about-blog footer-padding">
            <div class="container">
                <div class="blog-item customer-empty-state" data-aos="fade-up">
                    <div class="cart-img">
                        <img src="{{ asset('assets/website/assets/images/homepage-one/empty-wishlist.webp') }}" alt>
                    </div>
                    <div class="cart-content">
                        <p class="content-title">{{ __('website.no_products') }}</p>
                        <a href="{{ route('website.shop') }}" class="shop-btn">{{ __('website.back_to_shop') }}</a>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection

@push('js')
    @if ($flashTimer)
        <script src="{{ asset('assets/website/assets/js/flash-timer-products.js') }}"></script>
    @endif
@endpush