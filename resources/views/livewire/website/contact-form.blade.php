<div>
@if(auth('web')->check())

    <form wire:submit="submitContactForm">
        <div class="question-section login-section">
            <div class="review-form">
                <h5 class="comment-title">{{ __('website.get_in_touch') }}</h5>
                <div class="account-inner-form">
                    <div class="review-form-name">
                        <label for="fname" class="form-label">{{ __('website.name') }}*</label>
                        <input wire:model.live="name" type="text" id="fname" class="form-control"
                            placeholder="{{ __('website.name') }}" />
                        <span class="text-danger">
                            @error('name')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="review-form-name">
                        <label for="email" class="form-label">{{ __('website.email') }}*</label>
                        <input wire:model.live="email" type="email" id="email" class="form-control"
                            placeholder="user@gmail.com" />
                        <span class="text-danger">
                            @error('email')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                     <div class="review-form-name">
                        <label for="phone" class="form-label">{{ __('website.phone') }}*</label>
                        <input wire:model.live="phone" type="text" id="phone" class="form-control"
                            placeholder="0122000000" />
                        <span class="text-danger">
                            @error('phone')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="review-form-name">
                        <label for="subject" class="form-label">{{ __('website.subject') }}*</label>
                        <input wire:model.live="subject" type="text" id="subject" class="form-control"
                            placeholder="{{ __('website.subject') }}" />
                        <span class="text-danger">
                            @error('subject')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="review-textarea">
                    <label for="floatingTextarea">{{ __('website.message') }}*</label>
                    <textarea wire:model.live="message" class="form-control" placeholder="{{ __('website.write_message') }}..........."
                        id="floatingTextarea" rows="3"></textarea>
                    <span class="text-danger">
                        @error('message')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="login-btn">
                    <button type="submit" class="shop-btn">{{ __('website.send') }}</button>
                </div>
            </div>
        </div>
    </form>
@endif
</div>


@script
    <script>
        $wire.on('contact-form-submitted', (event) => {
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
