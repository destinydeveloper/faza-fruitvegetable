@extends('layouts.user')
@section('title', 'User \ Manager \ Barang Mentah')
@section('page-header', 'Manager Barang Mentah')

@push('css')
    {{-- NProgress --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/nprogress/nprogress.css') }}">
    {{-- DataTables Bootstrap --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/responsive.dataTables.min.css') }}">
    {{-- Alertify --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/alertify/css/alertify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/alertify/css/themes/default.min.css') }}">
@endpush

@push('meta')
    <meta name="api" content="{{ route('user.manager.barang_mentah.action') }}">    
    <meta name="assets" content="{{ asset('assets') }}">    
@endpush

@push('js')
    {{-- NProgress --}} 
    <script src="{{ asset('assets/vendor/nprogress/nprogress.min.js') }}"></script>
    {{-- DataTables --}}
    <script src="{{ asset('assets/vendor/datatables/datatables.min.js') }}"></script>
    {{-- Alertify --}}
    <script src="{{ asset('assets/vendor/alertify/alertify.min.js') }}"></script>
    {{-- Vue & Axios --}}
    <script src="{{ asset('assets/vendor/vue/vue.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/axios/axios.min.js') }}"></script>
    {{-- This Page Script --}}
@endpush

@section('content')
    <section class="dashboard-counts no-padding-bottom">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                </div>
            </div>
        </div>
    </section>
@stop

@push('js')
    <script>
        $('#sidebar-manager-barangmentah').addClass('active');
        // Configuration
        const loadTimeInterval = 200;
        const assets = $("meta[name='assets']").attr("content");
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        axios.defaults.baseURL = $("meta[name='api']").attr("content");
        axios.defaults.headers.common['X-CSRF-TOKEN'] = $("meta[name='csrf-token']").attr("content");
    </script>
@endpush