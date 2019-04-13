@extends('layouts.user')
@section('title', 'User \ Transaksi \ Barang Siap Keluar')
@section('page-header', 'Barang Siap Transaksi')


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

@push('js')
    {{-- NProgress --}} 
    <script src="{{ asset('assets/vendor/nprogress/nprogress.min.js') }}"></script>
    {{-- DataTables --}}
    <script src="{{ asset('assets/vendor/datatables/datatables.min.js') }}"></script>
    {{-- Alertify --}}
    <script src="{{ asset('assets/vendor/alertify/alertify.min.js') }}"></script>
    {{-- This Page Script --}}
@endpush

@section('content')
    <section class="dashboard-counts no-padding-bottom">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form v-on:submit.prevent="" class="form-inline" style="margin-bottom: 15px;">
                        {{-- <label style="margin-right: 10px;" for="filter">Filter : </label>
                        <select v-on:change="loadTable()" v-model="filter" class="form-control" id="filter">
                            <option value="semua">Semua</option>
                            <option value="kirim">Kirim Barang</option>
                            <option value="cod">COD</option>
                        </select> --}}
                        <span style="margin-left: 10px;">
                            <button v-on:click="refreshTable()" title="Refresh" class="btn btn-sm btn-warning">
                                <i class="fa fa-refresh"></i>
                            </button>
                        </span>
                    </form>
                    <table class="table table-sm table-hover display nowrap" style="width:100%" id="transaksi-table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Kode</th>
                                <th scope="col">userId</th>
                                <th scope="col">...</th>
                            </tr>
                        </thead>
                        {{-- <tbody>
                            <tr>
                                <td>1</td>
                                <td>F4Z4/0824/BAS14</td>
                                <td>VianDwi</td>
                                <td>Kirim Barang</td>
                                <td>
                                    <button class="btn btn-xs btn-primary">Lihat Detail</button>
                                </td>
                                <td>
                                    <button class="btn btn-xs btn-danger" title="Batalkan Konfirmasi" data-toggle="tooltip" data-placement="top" title="Tolak Konfirmasi">
                                        <i class="fa fa-fw fa-chevron-left"></i>
                                    </button>
                                    <button class="btn btn-xs btn-success" title="Kirim ke Penerima" data-toggle="tooltip" data-placement="top" title="Kirim ke Penerima">
                                        <i class="fa fa-fw fa-chevron-right"></i>
                                    </button>
                                    <button class="btn btn-xs btn-info" title="Detail Transaksi"  data-toggle="tooltip" data-placement="top" title="Detail Transaksi">
                                        <i class="fa fa-fw fa-info"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody> --}}
                    </table>
                </div>
            </div>
        </div>
    </section>
@stop

@push('meta')
    <meta name="api" content="{{ route('user.transaksi.barang_siap') }}">    
    <meta name="assets" content="{{ asset('assets') }}">    
@endpush

@push('js')
    <script>
    $('#sidebar-transaksi-siap').addClass('active');
    const loadTimeInterval = 200;
    // Vue
    var app = new Vue({
        el: '#app',
        data: {
            filter: 'semua',
            detail: [],
            transaksi: [],
            transaksi_barang_count: 0,
            nominal: 0,
            id: null
        },
        methods: {
            rupiah(angka) {
                var rupiah = '';		
                var angkarev = angka.toString().split('').reverse().join('');
                for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
                return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
            },
            loadStart(){
                NProgress.start();
                NProgress.set(0.4);
            },
            loadDone(){
                setTimeout(function(){NProgress.done();}, loadTimeInterval);
            },
            loadTable(){
                if (app ===  undefined) { this.loadStart(); } else { app.loadStart(); }
                $('#transaksi-table').dataTable().fnDestroy();
                this.table = $('#transaksi-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '',
                        data: { filter: this.filter },
                        error: function (jqXHR, textStatus, errorThrown) {
                        if (app ===  undefined) { this.loadDone(); } else { app.loadDone(); }
                            if (jqXHR.status == 500) {
                                alertify.error('Server error, Try again later');
                            } else {
                                alertify.error('['+jqXHR.status+'] Error : '+'['+jqXHR.statusText+']');
                            }
                        }
                    },
                    columns: [
                        {data: 'no'},
                        {data: 'kode'},
                        {data: 'user_id'},
                        {data: 'action', orderable: false, searchable: false},
                    ],
                    responsive: true,
                    drawCallback: function( settings ) {
                        app.loadDone();
                    },
                });
                $('#transaksi-table').on( 'search.dt', function (e, settings) {
                    if (app ===  undefined) { this.loadStart(); } else { app.loadStart(); }
                });
            },
            refreshTable(){
                this.table.ajax.reload( null, false );
            },
        },
        mounted() {
            this.loadTable();
        }
    });
    </script>
@endpush