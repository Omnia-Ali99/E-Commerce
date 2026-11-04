@extends('layouts.website.app')
@section('title', __('website.categories'))
@section('content')

    {{-- breadcrump and header title --}}
    <section class="blog about-blog">
        <div class="container">
            <div class="blog-bradcrum">
                <span><a href="{{ route('website.home') }}">{{ __('website.home') }}</a></span>
                <span class="devider">/</span>
                <span><a href="javascript:void(0)" class="active">{{ __('website.all_categories') }}</a></span>
            </div>
            <div class="blog-heading about-heading">
                <h1 class="heading">{{ __('website.categories') }}</h1>
            </div>
        </div>
    </section>

    {{-- categories section --}}
    <section class="product-category">
        <div class="container">
            <div class="category-section customer-taxonomy-grid customer-taxonomy-grid--tree">
                @forelse ($categories as $item)
                    <div class="product-wrapper" data-aos="fade-right" data-aos-duration="100">
                        <div class="wrapper-img">
                            <img src="{{ asset($item->icon ?: 'assets/website/assets/images/homepage-one/empty-wishlist.webp') }}"
                                alt="{{ $item->name }}">
                        </div>

                        <div class="wrapper-info">
                            <a href="{{ route('website.categories.products', $item->slug) }}"
                                class="wrapper-details">{{ $item->name }}</a>
                        </div>

                        @if (($item->activeChildren ?? collect())->isNotEmpty())
                            <div class="customer-category-children">
                                @include('website.partials.category-tree', [
                                    'categories' => $item->activeChildren,
                                ])
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="alert alert-info">{{ __('website.no_categories') }}</div>
                @endforelse

            </div>
        </div>
    </section>


@endsection