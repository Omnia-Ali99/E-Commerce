<!doctype html>
<html lang="en">

<!-- Mirrored from quomodothemes.website/html/shopus/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 15 Nov 2023 07:47:25 GMT -->
<head>
<meta charset="utf-8">
<meta name="keywords" content="ShopUS, bootstrap-5, bootstrap, sass, css, HTML Template, HTML,html, bootstrap template, free template, figma, web design, web development,front end, bootstrap datepicker, bootstrap timepicker, javascript, ecommerce template">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="{{asset('uploads/brands/'.$setting->favicon)}}">
<meta name="description" content="{{$setting->meta_description}}"></meta>
<title>{{$setting->site_name}}:@yield('title')</title>

<link rel="stylesheet" href="{{asset('assets/website')}}/css/swiper10-bundle.min.css">

<link rel="stylesheet" href="{{asset('assets/website')}}/css/bootstrap-5.3.2.min.css">

<link rel="stylesheet" href="{{asset('assets/website')}}/css/nouislider.min.css">

<link rel="stylesheet" href="{{asset('assets/website')}}/css/aos-3.0.0.css">

<link rel="stylesheet" href="{{asset('assets/website')}}/css/style.css">
</head>
<body>


@include('layouts.website.header')
@yield('content')
@include('layouts.website.footer')


<script src="{{asset('assets/website')}}/assets/js/jquery_3.7.1.min.js"></script>

<script src="{{asset('assets/website')}}/assets/js/bootstrap_5.3.2.bundle.min.js"></script>

<script src="{{asset('assets/website')}}/assets/js/nouislider.min.js"></script>

<script src="{{asset('assets/website')}}/assets/js/aos-3.0.0.js"></script>

<script src="{{asset('assets/website')}}/assets/js/swiper10-bundle.min.js"></script>

<script src="{{asset('assets/website')}}/assets/js/shopus.js"></script>
</body>

<!-- Mirrored from quomodothemes.website/html/shopus/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 15 Nov 2023 07:47:25 GMT -->
</html>