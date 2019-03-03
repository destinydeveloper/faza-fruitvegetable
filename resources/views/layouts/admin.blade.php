@extends('layouts.app')
@section('page-title')
    @yield('title') | Faza - Administrator
@stop

@section('content-header')
    {{-- HeaderNavbar:start --}}
    @include('admin._navbar')
    {{-- HeaderNavbar:end --}}

    
    {{-- Body:start --}}
    <div class="page-content d-flex align-items-stretch"> 
        <!-- Side Navbar -->
        @include('admin._sidebar')
        <div class="content-inner">
            <!-- Page Header-->
            <header class="page-header">
                <div class="container-fluid">
                    <h2 class="no-margin-bottom">@yield('page-header')</h2>
                </div>
            </header>

            <!-- Page Content-->
            @yield('content')

            <!-- Page Footer-->
            <footer class="main-footer">
            <div class="container-fluid">
                <div class="row">
                <div class="col-sm-6">
                    <p>&copy; FAZA 2019 by Destiny Developer</p>
                </div>
                <div class="col-sm-6 text-right">
                    <p class="text-grey">Bootstrapious</p>
                    <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
                </div>
                </div>
            </div>
            </footer>
        </div>
    </div>
    {{-- Body:end --}}
@stop

@push('js')
    <script src="{{ asset('assets/vendor/jquery.cookie/jquery.cookie.js') }}"> </script>
    <script src="{{ asset('assets/dist/js/front.js') }}"></script>    
@endpush