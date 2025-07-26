@extends('layouts.website.app')
@section('title', __('website.login'))
@section('content')
<section class="login footer-padding">
    <div class="container">
      <div class="login-section">
        <div class="review-form">
          <h5 class="comment-title">{{__('dashboard.login')}}</h5>
          @if($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
          <form id="formLogin" action="{{route('website.login.post')}}" method="POST">
            @csrf
            <div class="review-inner-form">
              <div class="review-form-name">
                <label for="email" class="form-label">{{__('dashboard.email')}}*</label>
                <input
                  name="email"
                  type="email"
                  id="email"
                  class="form-control"
                  placeholder="{{__('dashboard.email')}}"
                />
              </div>
              <div class="review-form-name">
                <label for="password" class="form-label">{{__('dashboard.password')}}*</label>
                <input
                  name="password"
                  type="password"
                  id="password"
                  class="form-control"
                  placeholder="{{__('dashboard.password')}}"
                />
              </div>
              <div class="review-form-name checkbox">
                <div class="checkbox-item">
                  <input name="remember" type="checkbox" />
                  <span class="address">{{__('dashboard.remember_me')}}</span>
                </div>
                <div class="forget-pass">
                  <p><a href="{{ route('password.request') }}" > {{__('dashboard.forget_password')}}?</a></p>
                </div>
              </div>
            </div>
            <div class="login-btn text-center">
              <a href="javascript:void(0)" onClick="document.getElementById('formLogin').submit()" class="shop-btn">{{__('dashboard.login')}}</a>
              <span class="shop-account"
                >{{__('dashboard.dont_have_account')}} ?<a href="{{route('website.register.get')}}"
                  > {{__('dashboard.sign_up_free')}}</a
                ></span
              >
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
@endsection