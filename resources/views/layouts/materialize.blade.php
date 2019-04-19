<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('material/css/materialize.min.css') }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('material/fonts/material-icons.css') }}">
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
    <script src="{{ asset('assets/vendor/vue/vue.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/axios/axios.min.js') }}"></script>
    
    @stack('js')
</body>
</html>