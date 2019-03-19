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
                    <form v-on:submit.prevent="" class="form-inline" style="margin-bottom: 15px;">
                        <span style="margin-left: 10px;">
                            <button v-on:click="refreshTable()" title="Refresh" class="btn btn-sm btn-warning">
                                <i class="fa fa-refresh"></i>
                                Refresh
                            </button>
                        </span>
                    </form>
                    <table class="table table-sm table-hover display nowrap" style="width:100%" id="barang-table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Barang</th>
                                <th scope="col">Penginput</th>
                                <th scope="col">Stok</th>
                                <th scope="col">...</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                        
            </div>
        </div>
    </section>
    {{-- Modal Edit --}}
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modalEditLabel">Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" v-on:submit.prevent="">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" v-model="nama">
                    </div>
                    <hr>
                    <div class="form-group">
                        <label>Stok</label>
                    <input type="text" class="form-control" v-model="stok">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button v-on:click="update()" type="button" class="btn btn-primary" data-dismiss="modal">Update</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
            </div>
        </div>
    </div>
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
    // VueJs Instance

    var app = new Vue({
        el: '#app',
        data: {
            nama: '',
            id: null,
            stok: 0,
        },
        methods: {
            loadStart(){
                NProgress.start();
                NProgress.set(0.4);
            },
            loadDone(){
                setTimeout(function(){NProgress.done();}, loadTimeInterval);
            },
            loadTable(){
                if (app ===  undefined) { this.loadStart(); } else { app.loadStart(); }
                $('#barang-table').dataTable().fnDestroy();
                this.table = $('#barang-table').DataTable({
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
                        {data: 'barang.nama'},
                        {data: 'user.nama'},
                        {data: 'stok'},
                        {data: 'action', orderable: false, searchable: false},
                    ],
                    responsive: true,
                    drawCallback: function( settings ) {
                        app.loadDone();
                    },
                });
                $('#barang-table').on( 'search.dt', function (e, settings) {
                    if (app ===  undefined) { this.loadStart(); } else { app.loadStart(); }
                });
            },
            refreshTable(){
                this.table.ajax.reload( null, false );
            },
            delete(id, nama, username) {
                let html = '<div style="text-align: center;">Yakin Akan menambahkan @' + nama + ' dari  @'+ username +'?</div>';
                alertify.confirm('Konfirmasi', html, function(){
                    app.loadStart();
                    axios.post('', {action: 'delete', 'id': id}).then(function(res){
                        if (res.data.status == 'success') {
                            alertify.success('Berhasil menghapus');
                        }
                        app.refreshTable();
                        app.loadDone();
                    }).catch(function(error){
                        error = error.response;
                        app.loadDone();
                        app.handleCatch(error);
                    });
                },function(){
                }).set({labels:{ok:'Hapus', cancel: 'Batal'}});
            },
            add(id, nama) {
                let html = '<div style="text-align: center;">Pidahkan @' + nama + ' ke Barang?</div>';
                alertify.confirm('Konfirmasi', html, function(){
                    app.loadStart();
                    axios.post('', {action: 'add', 'id': id}).then(function(res){
                        if (res.data.status == 'success') {
                            alertify.success('Berhasil memindahkan ke barang');
                        }
                        app.refreshTable();
                        app.loadDone();
                    }).catch(function(error){
                        error = error.response;
                        app.loadDone();
                        app.handleCatch(error);
                    });
                },function(){
                }).set({labels:{ok:'Pindahkan', cancel: 'Batal'}});

            },
            edit(id) {
                app.loadStart();
                axios.post('', {action: 'detail', 'id': id}).then(function(res){
                    if (res.data.status == 'success') {
                        app.nama = res.data.result.barang.nama;
                        app.stok = res.data.result.stok;
                        app.id = res.data.result.id;
                        $('#modalEdit').modal('show');
                    }
                    app.loadDone();
                }).catch(function(error){
                    error = error.response;
                    app.loadDone();
                    app.handleCatch(error);
                });
            },
            update() {
                app.loadStart();
                axios.post('', {action: 'update', 'id': app.id, stok: app.stok}).then(function(res){
                    if (res.data.status == 'success') {
                        alertify.success('Berhasil memperbarui');
                    }
                    app.refreshTable();
                    app.loadDone();
                }).catch(function(error){
                    error = error.response;
                    app.loadDone();
                    app.handleCatch(error);
                });
            },
            handleCatch(error) {
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
        mounted(){
            this.loadTable();
        }
    });
    </script>
@endpush