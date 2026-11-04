@extends('layouts.website.app')
@section('title',__('website.shop'))
@section('content')

<section class="product product-sidebar footer-padding">
    <div class="container">
        @livewire('website.shop')
    </div>
</section>

@endsection
