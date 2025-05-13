<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">
<head>
 @include('layouts.dashboard._head')
 @stack('css')
</head>
<body class="vertical-layout vertical-menu-modern 2-columns   menu-expanded fixed-navbar"
data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
  <!-- fixed-top-->
@include('layouts.dashboard._header')
  <!-- ////////////////////////////////////////////////////////////////////////////-->
 @include('layouts.dashboard._sidebar')
  @yield('content')
  <!-- ////////////////////////////////////////////////////////////////////////////-->
 @include('layouts.dashboard._footer')
 @include('layouts.dashboard._scripts')
 @stack('js')
</body>
</html>