@extends('layouts.dashboard.auth')
@section('title')
    Reset Password
@endsection
@section('content')
<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
        <section class="flexbox-container">
          <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="col-md-4 col-10 box-shadow-2 p-0">
              <div class="card border-grey border-lighten-3 px-2 py-2 m-0">
                <div class="card-header border-0 pb-0">
                  <div class="card-title text-center">
                    <img src="{{ asset('assets/dashboard') }}/images/logo/logo-dark.png" alt="branding logo">
                  </div>
                  <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                    <span>Enter New Password.</span>
                  </h6>
                </div>
                <div class="card-content">
                  <div class="card-body">
                    <form action="{{ route('dashboard.password.reset.post') }}" method="POST" class="form-horizontal"  novalidate>
                       @csrf
                        <fieldset hidden class="form-group position-relative has-icon-left">
                            <input
                              name="email"
                              value="{{ $email }}"
                              hidden type="email"
                              class="form-control form-control-lg input-lg"
                              id="user-email"
                              placeholder="Your Email Address" required
                              >
                            <div class="form-control-position">
                              <i class="ft-mail"></i>
                            </div>
                          </fieldset>
                          <fieldset  class="form-group position-relative has-icon-left">
                            <input
                                name="password"
                                type="password"
                                class="form-control form-control-lg input-lg"
                                id="user-email"
                                placeholder=" New Password"
                                >
                            <div class="form-control-position">
                              <i class="ft-mail"></i>
                            </div>
                            @error('password')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                          </fieldset>
                          <fieldset  class="form-group position-relative has-icon-left">
                            <input
                                 name="password_confirmation"
                                 type="password"
                                 class="form-control
                                 form-control-lg input-lg"
                                 id="user-email"
                                 placeholder=" New Password Confirmation"
                                 >
                            <div class="form-control-position">
                              <i class="ft-mail"></i>
                            </div>
                          </fieldset>
                      <button type="submit" class="btn btn-outline-info btn-lg btn-block"><i class="ft-unlock"></i> Reset Password</button>
                    </form>
                  </div>
                </div>
                <div class="card-footer border-0">
                  <p class="float-sm-left text-center"><a href="{{ route('dashboard.login') }}" class="card-link">Login</a></p>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
@endsection