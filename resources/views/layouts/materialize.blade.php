<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>@yield('page-title')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="assets" content="{{ asset('assets') }}">    
    @stack('meta')
    <style>body{display: none;}</style>
    <link rel="shortcut icon" href="{{ asset('assets/dist/img/favicon.ico') }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('material/css/materialize.min.css') }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('material/fonts/material-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/nprogress/nprogress.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/alertify/css/alertify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/alertify/css/themes/default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/custom.css') }}">
    @stack('css')
</head>
<body>
    <div id="master-app" class="page @yield('page-class')">
        @yield('content-header')
        @yield('content-main')
        @yield('content-footer')
    </div>
    @stack('modal')

    <script src="{{ asset('material/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('material/js/materialize.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/nprogress/nprogress.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/alertify/alertify.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/axios/axios.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/vue/vue.min.js') }}"></script>
    <script>const assets = $("meta[name='assets']").attr("content");const loadTimeInterval = 200;axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';axios.defaults.baseURL = $("meta[name='api']").attr("content");axios.defaults.headers.common['X-CSRF-TOKEN'] = $("meta[name='csrf-token']").attr("content");</script>
    @stack('js')
    <script>$('body').fadeIn(1500);</script>
</body>
</html>