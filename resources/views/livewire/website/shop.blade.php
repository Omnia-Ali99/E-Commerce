<div class="customer-shop">
    <div wire:loading class="customer-shop__loading">
        {{ __('website.loading') }}
    </div>

    <div class="row g-4">
        <div class="col-lg-3 sidebar-column">
            <aside class="customer-shop-filter">
                <div class="customer-shop-filter__section">
                    <h5>{{ __('website.categories') }}</h5>
                    <ul>
                        @forelse ($categories as $category)
                            <li>
                                <label class="customer-check">
                                    <input type="checkbox" wire:model.live="categoryIds" value="{{ $category->id }}">
                                    <span>{{ $category->name }}</span>
                                </label>
                            </li>
                        @empty
                            <li class="text-muted">{{ __('website.no_categories') }}</li>
                        @endforelse
                    </ul>
                </div>

                <div class="customer-shop-filter__section">
                    <h5>{{ __('website.price_range') }}</h5>
                    <div class="customer-price-inputs">
                        <label>
                            <span>{{ __('website.min_price') }}</span>
                            <input type="number" class="form-control" wire:model.live="minPrice" min="0">
                        </label>
                        <label>
                            <span>{{ __('website.max_price') }}</span>
                            <input type="number" class="form-control" wire:model.live="maxPrice" min="0">
                        </label>
                    </div>
                    <p class="customer-price-summary">
                        {!! \App\Support\Money::render($minPrice) !!}
                        <span class="customer-price-range-separator">-</span>
                        {!! \App\Support\Money::render($maxPrice) !!}
                    </p>
                </div>

                <div class="customer-shop-filter__section">
                    <h5>{{ __('website.brands') }}</h5>
                    <ul>
                        @forelse ($brands as $brand)
                            <li>
                                <label class="customer-check">
                                    <input type="checkbox" wire:model.live="brandIds" value="{{ $brand->id }}">
                                    <span>{{ $brand->name }}</span>
                                </label>
                            </li>
                        @empty
                            <li class="text-muted">{{ __('website.no_brands') }}</li>
                        @endforelse
                    </ul>
                </div>

                <div class="customer-shop-filter__section">
                    <h5>{{ __('website.active_filters') }}</h5>
                    @if (count($categoryIds) > 0 || count($brandIds) > 0 || $minPrice != 0 || $maxPrice != 10000)
                        <div class="customer-active-filters">
                            @foreach ($categoryIds as $catId)
                                @php $category = $categories->firstWhere('id', $catId); @endphp
                                @if ($category)
                                    <button type="button" wire:click="removeCategoryFilter({{ $catId }})">
                                        {{ $category->name }} x
                                    </button>
                                @endif
                            @endforeach

                            @foreach ($brandIds as $brId)
                                @php $brand = $brands->firstWhere('id', $brId); @endphp
                                @if ($brand)
                                    <button type="button" wire:click="removeBrandFilter({{ $brId }})">
                                        {{ $brand->name }} x
                                    </button>
                                @endif
                            @endforeach

                            @if ($minPrice != 0 || $maxPrice != 10000)
                                <button type="button" wire:click="setPriceRange(0, 10000)">
                                    {!! \App\Support\Money::render($minPrice) !!}
                                    <span class="customer-price-range-separator">-</span>
                                    {!! \App\Support\Money::render($maxPrice) !!}
                                    x
                                </button>
                            @endif
                        </div>
                        <button type="button" class="customer-clear-filter" wire:click="clearAllFilters">
                            {{ __('website.clear_all_filters') }}
                        </button>
                    @else
                        <p class="text-muted mb-0">{{ __('website.no_active_filters') }}</p>
                    @endif
                </div>
            </aside>
        </div>

        <div class="col-lg-9">
            <div class="product-sidebar-section">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="product-sorting-section customer-results-bar">
                            <div class="result">
                                <p>{{ __('website.showing') }}
                                    <span>{{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}</span>
                                    {{ __('website.of') }}
                                    <span>{{ $products->total() }}</span>
                                    {{ __('website.results') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    @forelse ($products as $item)
                        <div class="col-xl-4 col-sm-6">
                            @include('website.partials.product-card', [
                                'product' => $item,
                                'context' => 'shop-' . $loop->iteration,
                            ])
                        </div>
                    @empty
                        <div class="col-12">
                            <section class="blog about-blog footer-padding customer-empty-state">
                                <div class="container">
                                    <div class="blog-item">
                                        <div class="cart-img">
                                            <img src="{{ asset('assets/website/assets/images/homepage-one/empty-wishlist.webp') }}"
                                                alt>
                                        </div>
                                        <div class="cart-content">
                                            <p class="content-title">{{ __('website.no_products') }}</p>
                                            <button type="button" wire:click="clearAllFilters" class="shop-btn">
                                                {{ __('website.clear_all_filters') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    @endforelse

                    <div class="col-12">
                        <div class="customer-pagination">
                            {{ $products->links('vendor.livewire.customer-pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>