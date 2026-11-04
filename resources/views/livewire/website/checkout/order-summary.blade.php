<div>
    @php
        $items = $cart?->items ?? collect();
        $subTotal = $items->sum(fn ($item) => $item->price * $item->quantity);
        $total = $subTotal + $shippingPrice;
    @endphp

    <div class="customer-order-summary">
        <div class="customer-order-summary__header">
            <div>
                <span class="customer-order-summary__eyebrow">{{ __('website.secure_payment') }}</span>
                <h5>{{ __('website.order_summary') }}</h5>
            </div>
            <span class="customer-order-summary__count">{{ $items->count() }}</span>
        </div>

        <div class="customer-order-summary__items">
            @forelse ($items as $item)
                @php
                    $image = $item->product?->images?->first()?->file_name;
                    $imageUrl = $image
                        ? asset('uploads/products/' . $image)
                        : asset('assets/website/assets/images/homepage-one/empty-wishlist.webp');
                    $lineTotal = $item->price * $item->quantity;
                @endphp

                <div class="customer-summary-item">
                    <div class="customer-summary-item__image">
                        <img src="{{ $imageUrl }}" alt="{{ $item->product?->name ?? __('website.product') }}">
                        <span>{{ $item->quantity }}</span>
                    </div>
                    <div class="customer-summary-item__content">
                        <div class="customer-summary-item__top">
                            <h6>{{ $item->product?->name ?? __('website.product') }}</h6>
                            <strong>{!! \App\Support\Money::render($lineTotal) !!}</strong>
                        </div>
                        <div class="customer-summary-item__meta">
                            @if ($item->product_variant_id != null && is_iterable($item->attributes))
                                @foreach ($item->attributes as $key => $attr)
                                    <span>{{ $key }}: {{ $attr }}</span>
                                @endforeach
                            @else
                                <span>{{ __('website.no_variants') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="customer-summary-empty">
                    <p>{{ __('website.cart_empty') }}</p>
                </div>
            @endforelse
        </div>

        <div class="customer-summary-totals">
            <div class="customer-summary-row">
                <span>{{ __('website.sub_total') }}</span>
                <strong>{!! \App\Support\Money::render($subTotal) !!}</strong>
            </div>
            <div class="customer-summary-row">
                <span>{{ __('website.shipping') }}</span>
                <strong>+{!! \App\Support\Money::render($shippingPrice) !!}</strong>
            </div>
            <div class="customer-summary-row customer-summary-row--total">
                <span>{{ __('website.total') }}</span>
                <strong>{!! \App\Support\Money::render($total) !!}</strong>
            </div>
        </div>
    </div>
</div>