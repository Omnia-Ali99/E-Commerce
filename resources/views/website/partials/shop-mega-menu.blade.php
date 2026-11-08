@props([
    'categories' => collect(),
])

@php
    $categories = collect($categories);
    $featuredCategories = $categories->take(4);
    $fallbackImage = asset('assets/website/assets/images/homepage-one/empty-wishlist.webp');
@endphp

<div class="customer-shop-mega">
    <div class="customer-shop-mega__hero">
        <span class="customer-shop-mega__eyebrow">{{ __('website.categories') }}</span>
        <h4>{{ __('website.all_categories') }}</h4>
        <p>{{ __('website.discover_latest_styles') }}</p>
        <a href="{{ route('website.shop') }}" class="customer-shop-mega__cta">
            {{ __('website.shop_now') }}
        </a>
    </div>

    <div class="customer-shop-mega__content">
        @if ($categories->isNotEmpty())
            <div class="customer-shop-mega__featured">
                @foreach ($featuredCategories as $category)
                    @php
                        $rawIcon = $category->getRawOriginal('icon');
                        $imageUrl = $rawIcon ? asset($category->icon) : $fallbackImage;
                        $children = $category->activeChildren ?? collect();
                    @endphp

                    <a href="{{ route('website.categories.products', $category->slug) }}" class="customer-shop-mega-card">
                        <span class="customer-shop-mega-card__image">
                            <img src="{{ $imageUrl }}" alt="{{ $category->name }}">
                        </span>
                        <span class="customer-shop-mega-card__body">
                            <strong>{{ $category->name }}</strong>
                            <small>
                                {{ $children->isNotEmpty() ? $children->count() . ' ' . __('website.categories') : __('website.view_all') }}
                            </small>
                        </span>
                        <span class="customer-shop-mega-card__arrow" aria-hidden="true">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </a>
                @endforeach
            </div>

            <div class="customer-shop-mega__columns">
                @foreach ($categories as $category)
                    @php
                        $children = $category->activeChildren ?? collect();
                    @endphp

                    <div class="customer-shop-mega-column">
                        <a href="{{ route('website.categories.products', $category->slug) }}"
                            class="customer-shop-mega-column__title">
                            {{ $category->name }}
                        </a>

                        @if ($children->isNotEmpty())
                            <div class="customer-shop-mega-column__children">
                                @foreach ($children->take(5) as $child)
                                    <a href="{{ route('website.categories.products', $child->slug) }}">
                                        {{ $child->name }}
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <span class="customer-shop-mega-column__empty">{{ __('website.view_all') }}</span>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="customer-shop-mega__empty">
                <img src="{{ $fallbackImage }}" alt="{{ __('website.no_categories') }}">
                <p>{{ __('website.no_categories') }}</p>
            </div>
        @endif
    </div>
</div>