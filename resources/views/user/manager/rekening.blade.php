@extends('layouts.user')
@section('title', 'User \ Manager \ Rekening')
@section('page-header', 'Manager Rekening')

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
                    <span style="margin-left: 10px;">
                        <button v-on:click="refreshTable()" title="Refresh" class="btn btn-sm btn-warning">
                            <i class="fa fa-refresh"></i>
                        </button>
                        <button data-toggle="modal" data-target="#exampleModal" title="Tambah" class="btn btn-sm btn-success">
                            <i class="fa fa-plus"></i>
                        </button>
                    </span>
                </form>

                    <table class="table table-sm table-hover display nowrap" style="width:100%" id="rekening-table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Bank</th>
                                <th scope="col">Atas Nama</th>
                                <th scope="col">Nomor Rekening</th>
                                <th scope="col">...</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>

    {{-- Modal AddNew --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form">
                    <div class="form-group">
                        <label>Bank</label>
                        <input type="text" class="form-control" v-model="bank">
                    </div>
                    <div class="form-group">
                        <label>Atas Nama</label>
                        <input type="text" class="form-control" v-model="nama">
                    </div>
                    <div class="form-group">
                        <label>Nomor Rekening</label>
                        <input type="text" class="form-control" v-model="no">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button v-on:click="addNew()" type="button" class="btn btn-primary" data-dismiss="modal">Tambah</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form">
                    <div class="form-group">
                        <label>Bank</label>
                        <input type="text" class="form-control" v-model="bank">
                    </div>
                    <div class="form-group">
                        <label>Atas Nama</label>
                        <input type="text" class="form-control" v-model="nama">
                    </div>
                    <div class="form-group">
                        <label>Nomor Rekening</label>
                        <input type="text" class="form-control" v-model="no">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button v-on:click="update()" type="button" class="btn btn-primary" data-dismiss="modal">Update</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
            </div>
        </div>
    </div>
@stop

@push('meta')
    <meta name="api" content="{{ route('user.manager.rekening') }}">    
    <meta name="assets" content="{{ asset('assets') }}">    
@endpush

@push('js')
    <script>
    $('#sidebar-manager-rekening').addClass('active');
    const loadTimeInterval = 200;
    var app = new Vue({
        el: '#app',
        data: {
            id: 0,
            nama: "",
            no: "",
            bank: ""
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
                $('#rekening-table').dataTable().fnDestroy();
                this.table = $('#rekening-table').DataTable({
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
                        {data: 'nama'},
                        {data: 'bank'},
                        {data: 'nomor'},
                        {data: 'action', orderable: false, searchable: false},
                    ],
                    responsive: true,
                    drawCallback: function( settings ) {
                        app.loadDone();
                    },
                });
                $('#rekening-table').on( 'search.dt', function (e, settings) {
                    if (app ===  undefined) { this.loadStart(); } else { app.loadStart(); }
                });
            },
            refreshTable(){
                this.table.ajax.reload( null, false );
            },
            addNew(){
                let params = {
                    action: 'addnew',
                    bank: app.bank,
                    nama: app.nama,
                    no: app.no
                };

                app.loadStart();
                axios.post('', params).then(function(res){
                    if (res.data.status == 'success') {
                        app.refreshTable();
                        alertify.success('Berhasil menambahkan');
                    } else if (res.data.status == 'error') {
                        alertify.error(res.data.error);
                    } else {
                        alertify.error('Gagal menambahkan');
                    }
                    app.loadDone();
                }).catch(function(error){
                    error = error.response;
                    app.loadDone();
                    if (error.status == 422){
                        let errors  = error.data.errors;
                        Object.keys(errors).map(function(item, index){
                            alertify.error(errors[item][0]);
                        });
                    } else { app.handleCatch(error); }
                });
            },
            edit(id){
                let params = {
                    action: 'detail',
                    'id': id
                };
                app.loadStart();
                axios.post('', params).then(function(res){
                    app.loadDone();
                    if (res.data.status == 'success') {
                        app.id = id;
                        app.nama = res.data.result.nama;
                        app.bank = res.data.result.bank;
                        app.no = res.data.result.no;
                        $('#editModal').modal('show');
                    } else if (res.data.status == 'error') {
                        alertify.error(res.data.error);
                    } else {
                        alertify.error('Gagal');
                    }
                }).catch(function(error){
                    error = error.response;
                    app.loadDone();
                    if (error.status == 422){
                        let errors  = error.data.errors;
                        Object.keys(errors).map(function(item, index){
                            alertify.error(errors[item][0]);
                        });
                    } else { app.handleCatch(error); }
                });
            },
            update(){
                let params = {
                    action: 'update',
                    bank: app.bank,
                    nama: app.nama,
                    no: app.no,
                    id: app.id
                };

                app.loadStart();
                axios.post('', params).then(function(res){
                    if (res.data.status == 'success') {
                        app.refreshTable();
                        alertify.success('Berhasil memperbarui');
                    } else if (res.data.status == 'error') {
                        alertify.error(res.data.error);
                    } else {
                        alertify.error('Gagal memperbarui');
                    }
                    app.loadDone();
                }).catch(function(error){
                    error = error.response;
                    app.loadDone();
                    if (error.status == 422){
                        let errors  = error.data.errors;
                        Object.keys(errors).map(function(item, index){
                            alertify.error(errors[item][0]);
                        });
                    } else { app.handleCatch(error); }
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
        mounted() {
            this.loadTable();
        }
    });
    </script>    
@endpush