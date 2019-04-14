@extends('layouts.user')
@section('title', 'User \ Laporan \ Transaksi')
@section('page-header', 'Laporan Transaksi')


@section('content')
    <section class="dashboard-counts no-padding-bottom">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    Halaman Investor -Laporan Transaksi
                </div>
            </div>
        </div>
    </section>
@stop

@push('meta')
    <meta name="api" content="{{ route('user.laporan.transaksi') }}">    
    <meta name="assets" content="{{ asset('assets') }}">    
@endpush

@push('js')
    <script>
    // Buat ngasih active di sidebar
    $('#sidebar-laporan-transaksi').addClass('active');
    </script>
@endpush