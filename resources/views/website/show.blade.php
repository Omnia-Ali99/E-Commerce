@extends('layouts.website.app')
@section('title', __('dashboard.show'))
@section('content')

    <section class="product product-info">
        <div class="container">
            {{-- breadcrumb --}}
            <div class="blog-bradcrum">
                <span><a href="{{ route('website.home') }}">{{ __('website.home') }}</a></span>
                <span class="devider">/</span>
                <span><a href="{{ route('website.shop') }}">{{ __('website.shop') }}</a></span>
                <span class="devider">/</span>
                <span><a href="javascript:void(0)">{{ $product->name }}</a></span>
            </div>
            <div class="product-info-section">
                <div class="row ">
                    {{-- product images --}}
                    <div class="col-md-6">
                        <div class="product-info-img customer-product-gallery" data-aos="fade-right">
                            @if ($product->has_discount && $product->isSimple())
                                <div class="customer-product-gallery__discount">
                                    <span>{{ __('website.discount') }}</span>
                                    <strong>{{ $product->discountPercentage() }}</strong>
                                </div>
                            @endif
                            <div class="swiper product-top">
                                <div class="swiper-wrapper">
                                    @forelse ($product->images as $item)
                                        <div class="swiper-slide slider-top-img">
                                            <img src="{{ asset('uploads/products/' . $item->file_name) }}"
                                                alt="{{ $product->name }}">
                                        </div>
                                    @empty
                                        <div class="swiper-slide slider-top-img">
                                            <img src="{{ asset('assets/website/assets/images/homepage-one/empty-wishlist.webp') }}"
                                                alt="{{ $product->name }}">
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                            @if ($product->images->count() > 1)
                                <div class="swiper product-bottom customer-product-gallery__thumbs">
                                    <div class="swiper-wrapper">
                                        @foreach ($product->images as $item)
                                            <div class="swiper-slide slider-bottom-img">
                                                <img src="{{ asset('uploads/products/' . $item->file_name) }}"
                                                    alt="{{ $product->name }}">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    {{-- product Info --}}
                    <div class="col-md-6">
                        <div class="product-info-content">
                            <span class="wrapper-subtitle">{{ $product->category->name }}</span>
                            <h5>{{ $product->name }}
                            </h5>
                            <div class="ratings">
                                <span>
                                    <svg width="75" height="15" viewBox="0 0 75 15" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M7.5 0L9.18386 5.18237H14.6329L10.2245 8.38525L11.9084 13.5676L7.5 10.3647L3.09161 13.5676L4.77547 8.38525L0.367076 5.18237H5.81614L7.5 0Z"
                                            fill="#FFA800" />
                                        <path
                                            d="M22.5 0L24.1839 5.18237H29.6329L25.2245 8.38525L26.9084 13.5676L22.5 10.3647L18.0916 13.5676L19.7755 8.38525L15.3671 5.18237H20.8161L22.5 0Z"
                                            fill="#FFA800" />
                                        <path
                                            d="M37.5 0L39.1839 5.18237H44.6329L40.2245 8.38525L41.9084 13.5676L37.5 10.3647L33.0916 13.5676L34.7755 8.38525L30.3671 5.18237H35.8161L37.5 0Z"
                                            fill="#FFA800" />
                                        <path
                                            d="M52.5 0L54.1839 5.18237H59.6329L55.2245 8.38525L56.9084 13.5676L52.5 10.3647L48.0916 13.5676L49.7755 8.38525L45.3671 5.18237H50.8161L52.5 0Z"
                                            fill="#FFA800" />
                                        <path
                                            d="M67.5 0L69.1839 5.18237H74.6329L70.2245 8.38525L71.9084 13.5676L67.5 10.3647L63.0916 13.5676L64.7755 8.38525L60.3671 5.18237H65.8161L67.5 0Z"
                                            fill="#FFA800" />
                                    </svg>
                                </span>
                                <span class="text">{{ $product->productPreviews->count() }}
                                    {{ __('website.reviews') }}</span>
                            </div>

                            @livewire('website.product-details', ['product' => $product])

                            <hr>
                            <div class="product-details">
                                <p class="category">{{ __('website.category') }} : <span
                                        class="inner-text">{{ $product->category->name }}</span></p>
                                <p class="sku">{{ __('website.sku') }} : <span
                                        class="inner-text">{{ $product->sku }}</span></p>
                            </div>
                            <hr>

                            <div class="product-report customer-product-report">
                                <a href="#" class="report" onclick="modalAction('.action')">
                                    <span>
                                        <svg width="15" height="16" viewBox="0 0 15 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0 0C0.30478 0 0.585152 0 0.897442 0C0.908707 0.197137 0.919972 0.389267 0.932488 0.607056C1.30235 0.482516 1.64781 0.347336 2.00391 0.250332C3.83134 -0.247829 5.5555 0.0450599 7.19017 0.959399C7.97121 1.39686 8.7898 1.71165 9.68599 1.81178C10.9308 1.95072 12.0873 1.6716 13.1813 1.08832C13.4566 0.941876 13.7257 0.783541 14.0443 0.604553C14.0505 0.745991 14.0599 0.853634 14.0599 0.960651C14.0605 3.92396 14.058 6.88665 14.0662 9.84996C14.0668 10.079 13.9961 10.2042 13.7964 10.3143C11.4702 11.5973 9.14277 11.6123 6.82531 10.3106C4.99976 9.28546 3.14292 9.1484 1.22162 10.0164C0.990065 10.1209 0.908081 10.2524 0.909958 10.5096C0.921849 12.21 0.916217 13.911 0.916217 15.6114C0.916217 15.7353 0.916217 15.8586 0.916217 16C0.600172 16 0.312916 16 0 16C0 10.6779 0 5.35336 0 0Z"
                                                fill="#EB5757" />
                                        </svg>
                                    </span>
                                    <span>{{ __('website.report_this_item') }}</span>
                                </a>

                                <div class="modal-wrapper action">
                                    <div onclick="modalAction('.action')" class="anywhere-away"></div>

                                    <div class="login-section account-section modal-main">
                                        <div class="review-form">
                                            <div class="review-content">
                                                <h5 class="comment-title">{{ __('website.report_products') }}</h5>
                                                <div class="close-btn">
                                                    <img src="{{ asset('assets/website/assets/images/homepage-one/close-btn.png') }}"
                                                        onclick="modalAction('.action')" alt="close-btn">
                                                </div>
                                            </div>
                                            <div class="review-form-name address-form">
                                                <label for="reporttitle" class="form-label">{{ __('website.report_title') }}</label>
                                                <input type="text" id="reporttitle" class="form-control"
                                                    placeholder="{{ __('website.report_title_placeholder') }}">
                                            </div>
                                            <div class="review-form-name address-form">
                                                <label for="reportnote" class="form-label">{{ __('website.report_note') }}</label>
                                                <textarea name="ticketmassage" id="reportnote" cols="40" rows="3" class="form-control"
                                                    placeholder="{{ __('website.type_here') }}"></textarea>
                                            </div>
                                            <div class="login-btn text-center">
                                                <a href="#" onclick="modalAction('.action')" class="shop-btn">{{ __('website.submit_report') }}</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            @php
                                $shareUrl = urlencode(url()->current());
                            @endphp
                            <div class="product-share">
                                <p>{{ __('website.share_this') }} :</p>
                                <div class="social-icons">
                                    <!-- Facebook -->
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}"
                                        target="_blank" rel="noopener">
                                        <span class="facebook">
                                            <svg width="10" height="16" viewBox="0 0 10 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M3 16V9H0V6H3V4C3 1.3 4.7 0 7.1 0C8.3 0 9.2 0.1 9.5 0.1V2.9H7.8C6.5 2.9 6.2 3.5 6.2 4.4V6H10L9 9H6.3V16H3Z"
                                                    fill="#3E75B2" />
                                            </svg>
                                        </span>
                                    </a>

                                    <!-- Pinterest -->
                                    <a href="https://pinterest.com/pin/create/button/?url={{ $shareUrl }}"
                                        target="_blank" rel="noopener">
                                        <span class="pinterest">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M8 0C3.6 0 0 3.6 0 8C0 11.4 2.1 14.3 5.1 15.4C5 14.8 5 13.8 5.1 13.1C5.2 12.5 6 9.1 6 9.1C6 9.1 5.8 8.7 5.8 8C5.8 6.9 6.5 6 7.3 6C8 6 8.3 6.5 8.3 7.1C8.3 7.8 7.9 8.8 7.6 9.8C7.4 10.6 8 11.2 8.8 11.2C10.2 11.2 11.3 9.7 11.3 7.5C11.3 5.6 9.9 4.2 8 4.2C5.7 4.2 4.4 5.9 4.4 7.7C4.4 8.4 4.7 9.1 5 9.5C5 9.7 5 9.8 5 9.9C4.9 10.2 4.8 10.7 4.8 10.8C4.8 10.9 4.7 11 4.5 10.9C3.5 10.4 2.9 9 2.9 7.8C2.9 5.3 4.7 3 8.2 3C11 3 13.1 5 13.1 7.6C13.1 10.4 11.4 12.6 8.9 12.6C8.1 12.6 7.3 12.2 7.1 11.7C7.1 11.7 6.7 13.2 6.6 13.6C6.4 14.3 5.9 15.2 5.6 15.7C6.4 15.9 7.2 16 8 16C12.4 16 16 12.4 16 8C16 3.6 12.4 0 8 0Z"
                                                    fill="#E12828" />
                                            </svg>
                                        </span>
                                    </a>

                                    <!-- Twitter -->
                                    <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}" target="_blank"
                                        rel="noopener">
                                        <span class="twitter">
                                            <svg width="18" height="14" viewBox="0 0 18 14" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M17.0722 1.60052C16.432 1.88505 15.7562 2.06289 15.0448 2.16959C15.7562 1.74278 16.3253 1.06701 16.5742 0.248969C15.8985 0.640206 15.1515 0.924742 14.3335 1.10258C13.6933 0.426804 12.7686 0 11.7727 0C9.85206 0 8.28711 1.56495 8.28711 3.48557C8.28711 3.7701 8.32268 4.01907 8.39382 4.26804C5.51289 4.12577 2.9165 2.73866 1.17371 0.604639C0.889175 1.13814 0.71134 1.70722 0.71134 2.34742C0.71134 3.5567 1.31598 4.62371 2.27629 5.26392C1.70722 5.22835 1.17371 5.08608 0.675773 4.83711V4.87268C0.675773 6.5799 1.88505 8.00258 3.48557 8.32268C3.20103 8.39382 2.88093 8.42938 2.56082 8.42938C2.34742 8.42938 2.09845 8.39382 1.88505 8.35825C2.34742 9.74536 3.62784 10.7768 5.15722 10.7768C3.94794 11.7015 2.45412 12.2706 0.818041 12.2706C0.533505 12.2706 0.248969 12.2706 0 12.2351C1.56495 13.2309 3.37887 13.8 5.37062 13.8C11.8082 13.8 15.3294 8.46495 15.3294 3.84124C15.3294 3.69897 15.3294 3.52113 15.3294 3.37887C16.0052 2.9165 16.6098 2.31186 17.0722 1.60052Z"
                                                    fill="#3FD1FF" />
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>


    {{-- product description --}}
    <section class="product product-description">
        <div class="container">
            <div class="product-detail-section">
                <nav>
                    <div class="nav nav-tabs nav-item" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                            aria-selected="true">{{ __('website.description') }}</button>
                        <button class="nav-link" id="nav-review-tab" data-bs-toggle="tab" data-bs-target="#nav-review"
                            type="button" role="tab" aria-controls="nav-review"
                            aria-selected="false">{{ __('website.reviews') }}</button>

                    </div>
                </nav>
                <div class="tab-content tab-item" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"
                        tabindex="0">
                        <div class="customer-product-description-text">
                            {!! nl2br(e($product->desc ?: $product->small_desc)) !!}
                        </div>

                    </div>
                    {{-- previews  --}}
                    <div class="tab-pane fade" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab"
                        tabindex="0">
                        @livewire('website.product-preview', ['product' => $product])
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- related products --}}
    <section class="product weekly-sale product-weekly footer-padding customer-product-listing">
        <div class="container">
            <div class="section-title">
                <h5>{{ __('website.related_products') }}</h5>
                <a href="{{ route('website.products.related', $product->slug) }}"
                    class="view">{{ __('website.view_all') }}</a>
            </div>
            <div class="weekly-sale-section">
                <div class="row g-4">
                    @forelse ($relatedProducts as $item)
                        <div class="col-xl-3 col-lg-4 col-sm-6">
                            @include('website.partials.product-card', [
                                'product' => $item,
                                'context' => 'related-' . $loop->iteration,
                            ])
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">{{ __('website.no_products') }}</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

@endsection