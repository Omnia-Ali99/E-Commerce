@extends('layouts.website.app')
@section('title',__('website.wishlist'))

@section('content')
 <section class="blog about-blog">
      <div class="container">

        {{-- breadcrumb --}}
        <div class="blog-bradcrum">
          <span><a href="{{ route('website.home') }}">{{ __('website.home') }}</a></span>
          <span class="devider">/</span>
          <span><a href="javascript:void(0)">{{ __('website.wishlist') }}</a></span>
        </div>

        {{-- wishlist title --}}
        <div class="blog-heading about-heading">
          <h1 class="heading">{{ __('website.wishlist') }}</h1>
        </div>

      </div>
    </section>

    {{-- wishlist table --}}
    <section class="cart product wishlist footer-padding">
        @livewire('website.wishlist.wishlist-table',['wishlists'=>$wishlists])
    </section>
@endsection