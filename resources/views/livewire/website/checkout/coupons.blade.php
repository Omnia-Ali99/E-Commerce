<div>
    @if ($couponInfo != null)
        <p class="customer-coupon-message">{{ $couponInfo }}</p>
    @endif

    @if ($cartItemsCount > 0 && $cart->coupon == null)
        <div class="customer-coupon-box">
            <div class="customer-coupon-box__body">
                <input wire:model="code" class="form-control" placeholder="{{ __('website.coupon_code') }}">
                <button wire:click="applyCoupon" type="button" class="shop-btn">{{ __('website.apply') }}</button>
            </div>
        </div>
    @endif
</div>


@script
    <script>
        $wire.on('couponApplied', (event) => {
            Swal.fire({
                position: "top-center",
                icon: "success",
                title: event,
                showConfirmButton: false,
                timer: 10000
            });
        });

        $wire.on('couponNotValid', (event) => {
            Swal.fire({
                position: "top-center",
                icon: "error",
                title: event,
                showConfirmButton: false,
                timer: 3500
            });
        });
    </script>
@endscript