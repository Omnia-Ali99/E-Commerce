  <div class="product-review-section">
      <h5 class="intro-heading">{{ __('website.reviews') }}</h5>
      <div class="review-wrapper">

          @auth('web')
              <div class="customer-review-composer">
                  <div class="customer-review-composer__head">
                      <span class="customer-review-composer__icon"></span>
                      <div>
                          <label for="review">{{ __('website.write_a_review') }}</label>
                          <p>{{ __('website.review_form_hint') }}</p>
                      </div>
                  </div>

                  <textarea wire:model.live="review" id="review"
                      class="customer-review-composer__field @error('review') is-invalid @enderror"
                      maxlength="500" rows="4" placeholder="{{ __('website.review_placeholder') }}"></textarea>

                  <div class="customer-review-composer__meta">
                      <span class="@error('review') customer-review-composer__error @enderror">
                          @error('review')
                              {{ $message }}
                          @else
                              {{ __('website.review_min_hint') }}
                          @enderror
                      </span>
                      <span>{{ mb_strlen((string) $review) }}/500</span>
                  </div>

                  <button wire:click="submitReview" wire:loading.attr="disabled" wire:target="submitReview"
                      type="button" class="customer-review-composer__button">
                      <span wire:loading.remove wire:target="submitReview">{{ __('website.submit') }}</span>
                      <span wire:loading wire:target="submitReview">{{ __('website.loading') }}</span>
                  </button>
              </div>
          @endauth

          <div class="customer-product-reviews">
          @forelse ($product->productPreviews as $item)
              @php
                  $userImage = $item->user?->image
                      ? asset('uploads/users/' . $item->user->image)
                      : asset('assets/website/assets/images/homepage-one/aurthor-img-1.webp');
              @endphp
              <article class="customer-product-review">
                  <div class="customer-product-review__avatar">
                      <img src="{{ $userImage }}" alt="{{ $item->user?->name ?? __('website.not_provided') }}">
                  </div>
                  <div class="customer-product-review__body">
                      <div class="customer-product-review__head">
                          <div>
                              <h5>{{ $item->user?->name ?? __('website.not_provided') }}</h5>
                              <p>{{ $item->user?->country?->name ?? __('website.not_provided') }},
                                  {{ $item->user?->city?->name ?? __('website.not_provided') }}</p>
                          </div>
                          <div class="customer-product-review__rating" aria-label="5.0">
                              <span>★★★★★</span>
                              <strong>5.0</strong>
                          </div>
                      </div>
                      <p class="customer-product-review__comment">{{ $item->comment }}</p>
                  </div>
              </article>
          @empty
              <p class="customer-product-reviews__empty">{{ __('website.no_reviews_yet') }}</p>
          @endforelse
          </div>
      </div>
  </div>

  @script
      <script>
          $wire.on('reviewSubmitted', (event) => {
              Swal.fire({
                  position: "top-center",
                  icon: "success",
                  title: event,
                  showConfirmButton: false,
                  timer: 1500
              });
          });
      </script>
  @endscript