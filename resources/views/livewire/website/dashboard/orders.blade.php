<div>
    @if ($screen == 'orders')
        @if ($auth_user->orders->count() > 0)
            <div class="customer-orders">
                @foreach ($auth_user->orders as $order)
                    @php
                        $statusClass = 'customer-order-status--' . str_replace('_', '-', strtolower($order->status));
                    @endphp
                    <article class="customer-order-card" style="--order-index: {{ $loop->index }}">
                        <div class="customer-order-card__head">
                            <div class="customer-order-card__identity">
                                <span class="customer-order-card__icon"></span>
                                <div>
                                    <span class="customer-order-card__eyebrow">{{ __('website.order') }}</span>
                                    <h3>#{{ $order->id }}</h3>
                                </div>
                            </div>
                            <span class="customer-order-status {{ $statusClass }}">{{ $order->status }}</span>
                        </div>

                        <div class="customer-order-card__meta">
                            <div class="customer-order-card__meta-box customer-order-card__meta-box--total">
                                <span class="customer-order-card__meta-icon"></span>
                                <span>{{ __('website.total') }}</span>
                                <strong>{!! \App\Support\Money::render($order->total_price) !!}</strong>
                            </div>
                            <div class="customer-order-card__meta-box customer-order-card__meta-box--shipping">
                                <span class="customer-order-card__meta-icon"></span>
                                <span>{{ __('website.shipping') }}</span>
                                <strong>{{ $order->street }}, {{ $order->city }}</strong>
                            </div>
                            <div class="customer-order-card__meta-box customer-order-card__meta-box--date">
                                <span class="customer-order-card__meta-icon"></span>
                                <span>{{ __('website.date') }}</span>
                                <strong>{{ $order->created_at ? \Illuminate\Support\Carbon::parse($order->created_at)->format('M d, Y') : '' }}</strong>
                            </div>
                        </div>

                        <button wire:click="toggleOrderItems({{ $order->id }})" type="button"
                            class="customer-order-card__toggle {{ $expandedOrderId === $order->id ? 'is-expanded' : '' }}">
                            <span>{{ $expandedOrderId === $order->id ? __('website.hide') : __('website.view') }}
                                {{ __('website.items') }}</span>
                            <span class="customer-order-card__toggle-icon"></span>
                        </button>

                        @if ($expandedOrderId === $order->id)
                            <div class="customer-order-items">
                                @foreach ($order->orderItems as $item)
                                    <div class="customer-order-item" style="--item-index: {{ $loop->index }}">
                                        <span class="customer-order-item__bullet"></span>
                                        <div class="customer-order-item__content">
                                            <h4>{{ $item->product_name }}</h4>
                                            <p>{{ $item->product_desc }}</p>
                                        </div>
                                        <div class="customer-order-item__numbers">
                                            <span>{{ __('website.quantity') }}: {{ $item->product_quantity }}</span>
                                            <strong>{!! \App\Support\Money::render($item->product_price) !!}</strong>
                                        </div>

                                        @if ($item->attributes)
                                            <div class="customer-order-item__attrs">
                                                @foreach ($item->attributes as $key => $value)
                                                    <span>{{ $key }}: {{ $value }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </article>
                @endforeach
            </div>
        @else
            <section class="blog about-blog footer-padding">
                <div class="container">
                    <div class="blog-item customer-empty-state" data-aos="fade-up">
                        <div class="cart-img">
                            <img src="{{ asset('assets/website/assets/images/homepage-one/empty-wishlist.webp') }}"
                                alt>
                        </div>
                        <div class="cart-content">
                            <p class="content-title">{{ __('website.no_orders') }}</p>
                            <a href="{{ route('website.shop') }}"
                                class="shop-btn">{{ __('website.back_to_shop') }}</a>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif
</div>