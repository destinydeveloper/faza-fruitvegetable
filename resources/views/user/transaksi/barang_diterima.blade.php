@extends('layouts.user')
@section('title', 'User \ Transaksi \ Barang Diterima')
@section('page-header', 'Barang Diterima')


@section('content')
    <section class="dashboard-counts no-padding-bottom">
        <div class="container-fluid">
            <div class="card">

            </div>
        </div>
    </section>
@stop

@push('meta')
    <meta name="api" content="{{ route('user.transaksi.barang_diterima') }}">    
    <meta name="assets" content="{{ asset('assets') }}">    
@endpush

@push('js')
    <script>
    $('#sidebar-transaksi-diterima').addClass('active');
    </script>
@endpush