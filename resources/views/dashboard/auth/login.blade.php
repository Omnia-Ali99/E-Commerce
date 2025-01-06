@extends('layouts.dashboard.auth')
@section('title')
    Login
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
              <div class="card border-grey border-lighten-3 m-0">
                <div class="card-header border-0">
                  <div class="card-title text-center">
                    <img src="{{asset('assets/dashboard')}}/images/logo/logo-dark.png" alt="">
                  </div>
                  <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                    <span>{{__('auth.login')}}</span>
                  </h6>
                </div>
                <div class="card-content">
                  <div class="card-body">
                    <form class="form-horizontal" action="{{route('dashboard.login.post')}}" method="POST" novalidate>
                      @csrf
                      <fieldset class="form-group position-relative has-icon-left">
                        <input type="text" class="form-control input-lg" id="user-name" name="email" placeholder="{{__('auth.user-name')}}"
                        tabindex="1" >
                        @error('email')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        <div class="form-control-position">
                          <i class="ft-user"></i>
                        </div>
                        {{-- <div class="help-block font-small-3"></div> --}}
                      </fieldset>
                      <fieldset class="form-group position-relative has-icon-left">
                        <input type="password" class="form-control input-lg" id="password" name="password" placeholder="{{__('auth.password')}}"
                        tabindex="2">
                        <div class="form-control-position">
                          <i class="la la-key"></i>
                        </div>
                        {{-- <div class="help-block font-small-3"></div> --}}
                      </fieldset>
                      <fieldset class="form-group position-relative has-icon-left">
                        <div style="display: flex; justify-content: center;">
                            {!! NoCaptcha::display() !!}
                        </div>
                        @error('g-recaptcha-response')
                        <strong class="text-danger d-flex justify-content-center mt-2">{{ $message }}</strong>
                        @enderror
                    </fieldset>

                      <div class="form-group row">
                        <div class="col-md-6 col-12 text-center text-md-left">
                          <fieldset>
                            <input type="checkbox" id="remember-me" name="remember" class="chk-remember">
                            <label for="remember-me">{{__('auth.remember_me')}}</label>
                          </fieldset>
                        </div>
                        <div class="col-md-6 col-12 text-center text-md-right"><a href="{{route('dashboard.password.email')}}" class="card-link">{{__('auth.forget_password')}}</a></div>
                      </div>
                      <button type="submit" class="btn btn-danger btn-block btn-lg"><i class="ft-unlock"></i> {{__('auth.login')}}</button>
                    </form>
                  </div>
                </div>
                <div class="card-footer border-0">
                  {{-- <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">
                    <span>New to Modern ?</span>
                  </p>
                  <a href="register-advanced.html" class="btn btn-info btn-block btn-lg mt-3"><i class="ft-user"></i> Register</a> --}}
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div> 
@endsection