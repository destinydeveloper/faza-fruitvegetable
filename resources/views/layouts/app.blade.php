<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('page-title')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="all,follow">
    @stack('meta')
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/fontastic.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/style.default.css') }}" id="theme-stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/custom.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/dist/img/favicon.ico') }}">
    @stack('css')
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>
<body>
    <div id="app" class="page @yield('page-class')">
        @yield('content-header')
        @yield('content-main')
        @yield('content-footer')
    </div>
    
    @stack('modal')    
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/popper.js/umd/popper.min.js') }}"> </script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/vendor/jquery-validation/jquery.validate.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/dist/js/charts-home.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/Chart.min.js') }}"></script> --}}
    @stack('js')
</body>
</html>