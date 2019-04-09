@extends('layouts.user')
@section('title', 'User \ Transaksi \ Permintaan')
@section('page-header', 'Permintaan Transaksi')

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
                        <label style="margin-right: 10px;" for="filter">Filter : </label>
                        <select v-on:change="loadTable()" v-model="filter" class="form-control" id="filter">
                            <option value="semua">Semua</option>
                            <option value="belum">Belum Dibayar</option>
                            <option value="sudah">Sudah Dibayar</option>
                            <option value="cod">COD</option>
                        </select>
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
                                <th scope="col">UserID</th>
                                <th scope="col">Metode</th>
                                <th scope="col">Status</th>
                                <th scope="col">...</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="konfirmasiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Transaksi Ini?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Transaksi</a>
                    </li>
                    <li class="nav-item" v-if="transaksi.length != 0 && transaksi.metode == 'kirim barang'">
                        <a class="nav-link" id="bayar-tab" data-toggle="tab" href="#bayar" role="tab" aria-controls="bayar" aria-selected="false">Bayar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Pelanggan</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <table class="table">
                            <tr>
                                <th>ID</th>
                                <td>@{{ transaksi.id }}</td>
                            </tr>
                            <tr>
                                <th>Kode</th>
                                <td>@{{ transaksi.kode }}</td>
                            </tr>
                            <tr>
                                <th>Metode</th>
                                <td>@{{ transaksi.metode }}</td>
                            </tr>
                            <tr>
                                <th>Waktu</th>
                                <td>@{{ transaksi.created_at }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="bayar" role="tabpanel" aria-labelledby="bayar-tab">
                        <div style="margin-top: 15px;">
                            <div class="form">
                                <div class="form-group">
                                    <label>Bukti Pembayaran :</label>
                                    <div>Belum Ada</div>
                                </div>
                            </div>
                            <hr>
                            <div class="form">
                                <div class="form-group">
                                    <label>Nominal</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <table class="table">
                            <thead>
                                <th scope="col">#</th>
                                <th scope="col">Barang</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Stok</th>
                                <th scope="col">Catatan</th>
                            </thead>
                            <tbody>
                                <tr v-for="(item, i) in transaksi.barangs">
                                    <td>@{{ (i++)+1 }}</td>
                                    <td>@{{ item.barang.nama }}</td>
                                    <td>@{{ rupiah(item.harga) }}</td>
                                    <td>@{{ item.stok }}</td>
                                    <td>@{{ item.catatan }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        <h5 style="margin-top: 15px;">User</h5>
                        <table class="table" v-if="transaksi.length != 0">
                            <tr>
                                <th>ID</th>
                                <td>@{{ transaksi.user.id }}</td>
                            </tr>
                            <tr>
                                <th>Nama</th>
                                <td>@{{ transaksi.user.nama }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>@{{ transaksi.user.email }}</td>
                            </tr>
                        </table>

                        <hr>

                        <h5>Dikirim Ke</h5>
                        <table class="table" v-if="transaksi.length != 0">
                            <tr>
                                <th>Atas Nama</th>
                                <td>@{{ transaksi.alamat.penerima }}</td>
                            </tr>
                            <tr>
                                <th>No Telp</th>
                                <td>@{{ transaksi.alamat.no_telp }}</td>
                            </tr>
                            <tr>
                                <th>Kodepos</th>
                                <td>@{{ transaksi.alamat.kodepos }}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>@{{ transaksi.alamat.alamat }}</td>
                            </tr>
                            <tr>
                                <th>Alamat Lengkap</th>
                                <td>@{{ transaksi.alamat.alamat_lengkap }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Konfirmasi</button>
            </div>
        </div>
        </div>
    </div>
@stop

@push('meta')
    <meta name="api" content="{{ route('user.transaksi.permintaan') }}">    
    <meta name="assets" content="{{ asset('assets') }}">    
@endpush

@push('js')
    <script>
    $('#sidebar-transaksi-permintaan').addClass('active');
    // Configuration
    const loadTimeInterval = 200;
    // Vue
    var app = new Vue({
        el: '#app',
        data: {
            filter: 'semua',
            detail: [],
            transaksi: [],
            transaksi_barang_count: 0
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
                        {data: 'metode'},
                        {data: 'status'},
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
            konfirmasi(id){
                app.loadStart();
                axios.post('', { action: 'detail', 'id': id }).then(function(res){
                    app.loadDone();
                    console.log(res);
                    if (res.data.status == 'success') {
                        app.transaksi = res.data.result;
                        $('#konfirmasiModal').modal('show');
                    } else {
                        alertify.error(res.data.error);
                    }
                }).catch(function(error){
                    error = error.response;
                    app.loadDone();
                    app.handleCatch(error);
                });
            },
            delete(id, kode) {
                let html = '<div style="text-align: center;">Yakin Akan Menghapus Transaksi <span class="text-primary">' + kode + '</span>?</div>';
                alertify.confirm('Konfirmasi Hapus', html, function(){
                    app.loadStart();
                    axios.post('', { action: 'delete', 'id': id }).then(function(res){
                        app.loadDone();
                        if (res.data.status == 'success') {
                            alertify.success('Berhasil menghapus');
                        }
                        app.refreshTable();
                    }).catch(function(error){
                        error = error.response;
                        app.loadDone();
                        app.handleCatch(error);
                    });
                },function(){
                }).set({labels:{ok:'Hapus', cancel: 'Batal'}});
            },
            handleCatch(error){
                console.log(error);
                app.loadDone();
                if (error.status == 500) {
                    alertify.error('Server Error, Try again later');
                } else if (error.status == 422) {
                    alertify.error('Form invalid, Check input form');
                } else {
                    alertify.error('['+error.status+'] Error : '+'['+error.statusText+']');
                }
            },
        },
        mounted() {
            this.loadTable();
        }
    });
    </script>
@endpush