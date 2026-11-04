@extends('layouts.website.app')
@section('title', __('dashboard.brands'))
@section('content')

    {{-- breadcrump and header title --}}
    <section class="blog about-blog">
        <div class="container">
            <div class="blog-bradcrum">
                <span><a href="{{ route('website.home') }}">{{ __('website.home') }}</a></span>
                <span class="devider">/</span>
                <span><a href="javascript:void(0)" class="active">{{ __('website.all_brands') }}</a></span>
            </div>
            <div class="blog-heading about-heading">
                <h1 class="heading">{{ __('dashboard.brands') }}</h1>
            </div>
        </div>
    </section>

    {{-- Brands section --}}
    <section class="product brand" data-aos="fade-up">
        <div class="container">

            <div class="brand-section customer-taxonomy-grid">
                @forelse ($brands as $item)
                    <div class="product-wrapper">
                        <div class="wrapper-img">
                            <a href="{{ route('website.brands.products',$item->slug) }}">
                                <img src="{{ asset($item->logo ?: 'assets/website/assets/images/homepage-one/empty-wishlist.webp') }}"
                                    alt="{{ $item->name }}">
                            </a>
                        </div>
                        <div class="wrapper-info">
                            <a href="{{ route('website.brands.products', $item->slug) }}" class="wrapper-details">
                                {{ $item->name }}
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info">{{ __('website.no_brands') }}</div>
                @endforelse

            </div>
        </div>
    </section>

@endsection