@php
    $context = $context ?? 'default';
    $image = $product->images->first()?->file_name;
    $imageUrl = $image
        ? asset('uploads/products/' . $image)
        : asset('assets/website/assets/images/homepage-one/empty-wishlist.webp');
    $brandName = $product->brand?->name;
    $category = $product->category;
    $hasVariants = (bool) $product->has_variants;
    $hasDiscount = !$hasVariants && (bool) $product->has_discount;
    $variantPrices = $hasVariants
        ? $product->variants->pluck('price')->filter(fn ($price) => $price !== null)->sort()->values()
        : collect();
    $minVariantPrice = $variantPrices->first();
    $maxVariantPrice = $variantPrices->last();
@endphp

<article class="customer-product-card">
    <div class="customer-product-card__media">
        <a href="{{ route('website.products.show', $product->slug) }}" aria-label="{{ $product->name }}">
            <img src="{{ $imageUrl }}" alt="{{ $product->name }}">
        </a>

        @if ($brandName)
            <span class="customer-product-card__badge">{{ $brandName }}</span>
        @endif

        <div class="customer-product-card__actions">
            <a href="{{ route('website.products.show', $product->slug) }}"
                class="customer-product-card__icon"
                aria-label="{{ __('website.view_details') }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 12s3.2-6 9-6 9 6 9 6-3.2 6-9 6-9-6-9-6Z" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
            <div class="customer-product-card__icon customer-product-card__wishlist">
                {{-- @livewire('website.wishlist.wishlist', ['product' => $product], key('wishlist-card-' . $context . '-' . $product->id)) --}}
            </div>
        </div>
    </div>

    <div class="customer-product-card__body">
        @if ($category)
            <a href="{{ route('website.categories.products', $category->slug) }}" class="customer-product-card__category">
                {{ $category->name }}
            </a>
        @endif

        <h3 class="customer-product-card__title">
            <a href="{{ route('website.products.show', $product->slug) }}">{{ $product->name }}</a>
        </h3>

        <div class="customer-product-card__footer">
            <div class="customer-product-card__price">
                @if ($hasVariants)
                    @if ($variantPrices->isNotEmpty())
                        <span class="customer-product-card__current">
                            @if ($minVariantPrice == $maxVariantPrice)
                                {{-- {!! \App\Support\Money::render($minVariantPrice) !!} --}}
                            @else
                                {{-- {!! \App\Support\Money::render($minVariantPrice) !!} --}}
                                <span class="customer-product-card__range-separator">-</span>
                                {{-- {!! \App\Support\Money::render($maxVariantPrice) !!} --}}
                            @endif
                        </span>
                    @else
                        <span class="customer-product-card__current">{{ __('website.has_variants') }}</span>
                    @endif
                @elseif ($hasDiscount)
                    {{-- <span class="customer-product-card__old">{!! \App\Support\Money::render($product->price, 'customer-money customer-money--old') !!}</span> --}}
                    {{-- <span class="customer-product-card__current">{!! \App\Support\Money::render($product->getPriceAfterDiscount()) !!}</span> --}}
                @else
                    {{-- <span class="customer-product-card__current">{!! \App\Support\Money::render($product->price) !!}</span> --}}
                @endif
            </div>

            <a href="{{ route('website.products.show', $product->slug) }}" class="customer-product-card__details">
                {{ __('website.view_details') }}
            </a>
        </div>
    </div>
</article>