 <div>
      @if ($screen == 'change_password')
          <div class="tab-pane fade @if ($screen == 'change_password') active show @endif">
              <div class="row align-items-center">
                  <div class="col-lg-6">
                      <div class="form-section">
                          <form action="#">
                              <div class="currentpass form-item">
                                  <label for="currentpass" class="form-label">{{ __('website.current_password') }}*</label>
                                  <input wire:model="old_password" type="password" class="form-control" id="currentpass"
                                      placeholder="******">
                                  @error('old_password')
                                      <strong class="text-danger">
                                          {{ $message }}
                                      </strong>
                                  @enderror
                              </div>
                              <div class="password form-item">
                                  <label for="pass" class="form-label">{{ __('website.password') }}*</label>
                                  <input wire:model="password" type="password" class="form-control" id="pass"
                                      placeholder="******">
                                  @error('password')
                                      <strong class="text-danger">
                                          {{ $message }}
                                      </strong>
                                  @enderror
                              </div>
                              <div class="re-password form-item">
                                  <label for="repass" class="form-label">{{ __('website.reenter_password') }}*</label>
                                  <input wire:model="password_confirmation" type="password" class="form-control"
                                      id="repass" placeholder="******">
                                        @error('password_confirmation')
                                      <strong class="text-danger">
                                          {{ $message }}
                                      </strong>
                                  @enderror
                              </div>
                          </form>
                          <div class="form-btn">
                              <a href="javascript:void(0)"  wire:click="updatePassword" class="shop-btn">{{ __('website.update_password') }}</a>
                              <a href="javascript:void(0)" wire:click="resetForm" class="shop-btn cancel-btn">{{ __('website.cancel') }}</a>
                          </div>
                      </div>
                  </div>
                    <div class="col-lg-6">
                      <div class="reset-img text-end">
                          <img src="{{asset('assets/website/assets/images/homepage-one/reset.webp')}}" alt="reset">
                      </div>
                  </div>
              </div>
          </div>
      @endif
  </div>

 
@script
    <script>
        $wire.on('oldPasswordNotMatched', (event) => {
            Swal.fire({
                position: "top-center",
                icon: "error",
                title: event,
                showConfirmButton: false,
                timer: 3000,
            });
        });
        $wire.on('passwordChanged', (event) => {
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