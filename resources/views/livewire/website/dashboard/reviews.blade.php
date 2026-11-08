<div>
    @if ($screen == 'reviews')
        <div class="tab-pane fade @if ($screen == 'reviews') active show @endif">
            @if ($reviews->count() > 0)
                <div class="customer-review-grid">
                    @foreach ($reviews as $item)
                        @php
                            $image = $item->product->images->first()?->file_name;
                            $imageUrl = $image
                                ? asset('uploads/products/' . $image)
                                : asset('assets/website/assets/images/homepage-one/empty-wishlist.webp');
                        @endphp
                        <article class="customer-review-card">
                            <a href="{{ route('website.products.show', $item->product->slug) }}"
                                class="customer-review-card__image">
                                <img src="{{ $imageUrl }}" alt="{{ $item->product->name }}">
                            </a>

                            <div class="customer-review-card__body">
                                <div class="customer-review-card__meta">
                                    <span>{{ \Illuminate\Support\Carbon::parse($item->created_at)->diffForHumans() }}</span>
                                    <span class="customer-review-card__stars">★★★★★</span>
                                </div>

                                <a href="{{ route('website.products.show', $item->product->slug) }}"
                                    class="customer-review-card__title">
                                    {{ $item->product->name }}
                                </a>

                                <p class="customer-review-card__comment">{{ $item->comment }}</p>

                                <div class="customer-review-card__actions">
                                    <a href="" wire:click.prevent="editReview({{ $item->id }})"
                                        class="product-btn">{{ __('website.edit_review') }}</a>
                                    <a href="" data-id="{{ $item->id }}" class="product-btn delete-review">
                                        {{ __('website.delete_review') }}
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="customer-pagination">
                    {{ $reviews->links('vendor.livewire.customer-pagination') }}
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
                                <p class="content-title">{{ __('website.no_reviews') }}</p>
                                <a href="{{ route('website.shop') }}"
                                    class="shop-btn">{{ __('website.back_to_shop') }}</a>
                            </div>
                        </div>
                    </div>
                </section>
            @endif
        </div>
    @endif

    @if ($showModal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('website.edit_review') }}</h5>
                        <button type="button" class="btn-close" wire:click="$set('showModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        <textarea class="form-control" wire:model="editReviewComment" rows="4"></textarea>
                        @error('editReviewComment')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary"
                            wire:click="$set('showModal', false)">{{ __('website.close') }}</button>
                        <button class="btn btn-primary" wire:click="updateReview">{{ __('website.save_changes') }}</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@script
    <script>
        $wire.on('reviewUpdated', (event) => {
            Swal.fire({
                position: "top-center",
                icon: "success",
                title: event,
                showConfirmButton: false,
                timer: 3000,
            });
        });

        $(document).on('click', '.delete-review', function(e) {
            e.preventDefault();
            var review_id = $(this).attr('data-id');

            Swal.fire({
                title: @js(__('website.are_you_sure')),
                text: @js(__('website.confirm_delete_warning')),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: @js(__('website.yes_delete_it'))
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch('deleteReview', {
                        reviewId: review_id
                    });
                }
            });
        });

        $wire.on('reviewDeleted', (event) => {
            Swal.fire({
                position: "top-center",
                icon: "success",
                title: event,
                showConfirmButton: false,
                timer: 3000,
            });
        });
    </script>
@endscript