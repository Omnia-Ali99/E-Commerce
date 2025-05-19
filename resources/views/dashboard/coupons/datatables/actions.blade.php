<div class="form-group">
    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">

        <button
            class="edit_coupon btn btn-outline-success"
            coupon-id="{{ $coupon->id }}"
            coupon-code="{{ $coupon->code }}"
            coupon-limit="{{ $coupon->limit }}"
            coupon-discount="{{ $coupon->discount_precentage }}"
            coupon-start-date="{{ $coupon->start_date }}"
            coupon-end-date="{{ $coupon->end_date }}"
            coupon-status="{{ $coupon->is_active }}"
        >
           {{ __('dashboard.edit') }} <i class="la la-edit"></i>
        </button>


        <a href="{{ route('dashboard.coupons.edit', $coupon->id) }}" type="button" class="btn btn-outline-info">
            {{ __('dashboard.status_management') }} <i class="la la-stop"></i>
        </a>


            <button id="btnGroupDrop2" coupon-id="{{ $coupon->id }}" type="button" class="delete_confirm_btn btn btn-outline-danger">
                {{ __('dashboard.delete') }}<i class="la la-trash"></i>
            </button>


    </div>
</div>