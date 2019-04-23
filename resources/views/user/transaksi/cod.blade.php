@extends('layouts.user')
@section('title', 'User \ Transaksi \ Cash On Delivery')
@section('page-header', 'Transaksi Cash On Delivery')

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
                        <table class="table table-sm table-hover display nowrap" style="width:100%" id="table-cod">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Kode</th>
                                    <th scope="col">userId</th>
                                    <th scope="col">...</th>
                                </tr>
                            </thead>
                        </table>                    
                </div>
            </div>
        </div>
    </section>



    <!-- Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">data</a>
                        </li>
                        <li class="nav-item" v-if="data.length != 0 && data.metode == 'kirim barang'">
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
                                    <td>@{{ data.id }}</td>
                                </tr>
                                <tr>
                                    <th>Kode</th>
                                    <td>@{{ data.kode }}</td>
                                </tr>
                                <tr>
                                    <th>Metode</th>
                                    <td>@{{ data.metode }}</td>
                                </tr>
                                <tr>
                                    <th>Waktu</th>
                                    <td>@{{ data.created_at }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="bayar" role="tabpanel" aria-labelledby="bayar-tab" v-if="data.length != 0 && data.metode == 'kirim barang'">
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
                                        <input v-bind:value="data.bayar.nominal" type="text" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Catatan</label>
                                        <textarea class="form-control" readonly>@{{ data.bayar.catatan }}</textarea>
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
                                    <tr v-for="(item, i) in data.barangs">
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
                            <table class="table" v-if="data.length != 0">
                                <tr>
                                    <th>ID</th>
                                    <td>@{{ data.user.id }}</td>
                                </tr>
                                <tr>
                                    <th>Nama</th>
                                    <td>@{{ data.user.nama }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>@{{ data.user.email }}</td>
                                </tr>
                            </table>
    
                            <hr>
    
                            <h5>Dikirim Ke</h5>
                            <table class="table" v-if="data.length != 0">
                                <tr>
                                    <th>Atas Nama</th>
                                    <td>@{{ data.alamat.penerima }}</td>
                                </tr>
                                <tr>
                                    <th>No Telp</th>
                                    <td>@{{ data.alamat.no_telp }}</td>
                                </tr>
                                <tr>
                                    <th>Kodepos</th>
                                    <td>@{{ data.alamat.kodepos }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>@{{ data.alamat.alamat }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat Lengkap</th>
                                    <td>@{{ data.alamat.alamat_lengkap }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
    
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
            </div>
        </div>

     <!-- Modal -->
     <div class="modal fade" id="diterimaModal" tabindex="-1" role="dialog" aria-labelledby="diterimaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="diterimaModalLabel">Konfirmasi barang Sudah Diterima</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="form">
                    <div class="form-group">
                        <label>Transaksi</label>
                        <input type="text" class="form-control" v-bind:value="transaksi.kode" readonly>
                    </div>
                    <div class="form-group">
                        <label>Pengantar</label>
                        <input type="text" class="form-control" v-model="pengantar">
                    </div>
                    <div class="form-group">
                        <label>Penerima</label>
                        <input type="text" class="form-control" v-model="penerima">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button v-on:click="konfirmasiNow" type="button" class="btn btn-primary" data-dismiss="modal">Konfirmasi</button>
            </div>
        </div>
        </div>
    </div>
@stop

@push('meta')
    <meta name="api" content="{{ route('user.transaksi.cod') }}">    
    <meta name="assets" content="{{ asset('assets') }}">    
@endpush

@push('js')
    <script>
    $('#sidebar-transaksi-cod').addClass('active');
    const loadTimeInterval = 200;
    // Vue
    var app = new Vue({
        el: '#app',
        data: {
            filter: 'semua',
            transaksi: [],
            data: [],
            transaksi_barang_count: 0,
            nominal: 0,
            id: null,
            pengantar: "",
            penerima: ""
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
                $('#table-cod').dataTable().fnDestroy();
                this.table = $('#table-cod').DataTable({
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
                $('#table-cod').on( 'search.dt', function (e, settings) {
                    if (app ===  undefined) { this.loadStart(); } else { app.loadStart(); }
                });
            },
            refreshTable(){
                this.table.ajax.reload( null, false );
            },
            detail(id){
                app.loadStart();
                axios.post('', { action: 'detail', 'id': id }).then(function(res){
                    app.loadDone();
                    if (res.data.status == 'success') {
                        app.data = res.data.result;
                        app.transaksi = res.data.result;
                        $('#detailModal').modal('show');
                    } else {
                        alertify.error(res.data.error);
                    }
                }).catch(function(error){
                    error = error.response;
                    app.loadDone();
                    app.handleCatch(error);
                });
            },
            selesai(id){
                app.loadStart();
                axios.post('', { action: 'detail', 'id': id }).then(function(res){
                    app.loadDone();
                    if (res.data.status == 'success') {
                        app.transaksi = res.data.result;
                        $('#diterimaModal').modal('show');
                    } else {
                        alertify.error(res.data.error);
                    }
                }).catch(function(error){
                    error = error.response;
                    app.loadDone();
                    app.handleCatch(error);
                });
            },
            konfirmasiNow(){
                let params = { 
                    action: 'selesai',
                    'id': app.transaksi.id ,
                    pengantar: app.pengantar,
                    penerima: app.penerima
                }

                app.loadStart();
                axios.post('', params).then(function(res){
                    app.loadDone();
                    console.log(res);
                    if (res.data.status == 'success') {
                        alertify.success("Transaksi dikonfirmasi terima");
                        app.refreshTable();
                    } else {
                        alertify.error(res.data.error);
                    }
                }).catch(function(error){
                    error = error.response;
                    app.loadDone();
                    app.handleCatch(error);
                });
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