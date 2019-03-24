@extends('layouts.user')
@section('title', 'User \ Manager \ Input Barang Mentah')
@section('page-header', 'Manager Input Barang Mentah')

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
    <meta name="api" content="{{ route('user.manager.input_barang_mentah.action') }}">    
    <meta name="assets" content="{{ asset('assets') }}">    
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
                    <div class="row">
                        <div class="col-5 offset-3">
                            <form class="form" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Barang</label>
                                    <div class="input-group mb-3">
                                        <input v-model="barang_nama" readonly class="form-control" type="text" name="barang">
                                        <div class="input-group-append">
                                            <button v-on:click.prevent="$('#exampleModal').modal('show');" class="btn btn-outline-secondary">Pilih</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Stok</label>
                                    <div class="input-group mb-3">
                                        <input v-model="stok" class="form-control" type="text" name="stok">
                                        <div class="input-group-append">
                                        <span class="input-group-text">@{{ satuan_stok }}</span>
                                        </div>
                                    </div>
                                </div>
                                <button v-on:click.prevent="addNew()" class="btn btn-primary btn-block">Input</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h3>Riwayat Input Barang Mentah</h3>
                    <hr>
                    <a v-on:click.prevent="" v-for="(item, i) in riwayat" href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">@{{ item.barang.nama }}</h5>
                            <small>@{{ item.created_at }}</small>
                        </div>
                        @{{ item.stok }} @{{ item.barang.satuan_stok }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Modal AddNew --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pilih Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: 60vh!important;overflow-y: auto !important;padding: 0;">
                <input v-model="search" type="text" class="form-control" v-on:input="isTyping = true" placeholder="Search... Input Minimal 3 Character...">
                <div class="list-group">
                    <div v-if="search.length < 3">
                        <div style="text-align: center;margin: 20px 0;">
                            Cari barang yang anda ingin dengan mengetikan minal 3 karakter.
                        </div>
                    </div>
                    <div v-else>
                        <div v-if="isLoading">
                            <div style="text-align: center;">Sedang mencari...</div>
                        </div>
                        <div v-else>
                            <div v-if="searchResult.length == 0">
                                <div style="text-align: center;margin: 20px 0;">Tidak ada satupun.</div>
                            </div>
                            <div v-else>
                                <a v-on:click.prevent="applyBarang(item.id, item.nama, item.satuan_stok)" v-for="(item, i) in searchResult"  href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">@{{ item.nama }}</h5>
                                        <small>@{{ item.jenis }}</small>
                                    </div>
                                    @{{ rupiah(item.harga) }}
                                </a>
                            </div>
                        </div>
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
@stop

@push('js')
    <script>
    $('#sidebar-manager-inputbarangmentah').addClass('active');
    // Configuration
    const loadTimeInterval = 200;
    // VueJs Instance
    var app = new Vue({
        el: '#app',
        data: {
            barang: {id: null, nama: null},

            isTyping: false,
            search: '',
            searchResult: [],
            timeout: null,
            isLoading: false,
            satuan_stok: 'Stok',

            stok: 0,
            riwayat: []
        },
        watch: {
            search: function(){
                app.isLoading = true;
                clearTimeout(this.timeout);
                this.timeout = setTimeout(function(){ 
                    app.isTyping = false;
                    app.isLoading = false;
                }, 1000);
            },
            isTyping: function(value) {
                if (!value && this.search.length > 2) {
                    this.getBarang();
                }
            }
        },
        computed: {
            barang_nama (){
                if (this.barang.id === null) {
                    return "Pilih Barang Dahulu";
                } else {
                    return this.barang.nama;
                }
            }
        },
        methods: {
            loadStart(){
                NProgress.start();
                NProgress.set(0.4);
            },
            loadDone(){
                setTimeout(function(){NProgress.done();}, loadTimeInterval);
            },
            getRiwayat(){
                if (app ===  undefined) { this.loadStart(); } else { app.loadStart(); }
                axios.post('', {action: 'riwayat'}).then(function(res){
                    if (res.data.status == 'success') {
                        app.riwayat = res.data.result;
                    }
                    if (app ===  undefined) { this.loadDone(); } else { app.loadDone(); }
                }).catch(function(error){
                    error = error.response;
                    if (app ===  undefined) { this.loadDone(); } else { app.loadDone(); }
                    if (app ===  undefined) { this.handleCatch(error); } else {  app.handleCatch(error); }
                });
            },
            getBarang() {
                app.isLoading = true;
                app.loadStart();
                axios.post('', {action: 'search', 'search': this.search}).then(function(res){
                    if (res.data.status == 'success') {
                        app.searchResult = res.data.result;
                    }
                    app.loadDone();
                    app.isLoading = false;
                }).catch(function(error){
                    this.isLoading = false;
                    error = error.response;
                    app.loadDone();
                    app.handleCatch(error);
                });
            },
            rupiah(angka) {
                var rupiah = '';		
                var angkarev = angka.toString().split('').reverse().join('');
                for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
                return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
            },
            applyBarang(id, nama, stok) {
                $('#exampleModal').modal('hide');
                this.barang = { 'id': id, 'nama': nama};
                this.satuan_stok = stok;
            },
            addNew(){
                app.loadStart();
                axios.post('', {action: 'addnew', 'barang': this.barang.id, stok: this.stok}).then(function(res){
                    if (res.data.status == 'success') {
                        alertify.success("Berhasil menambahkan.");
                        app.getRiwayat();
                        app.barang.id = null;
                        app.stok = 0;
                        app.satuan_stok = "Stok";
                    }
                    app.loadDone();
                }).catch(function(error){
                    error = error.response;
                    app.loadDone();
                    if (error.status == 422 && error.statusText == "Unprocessable Entity"){
                        let errors  = error.data.errors;
                        Object.keys(errors).map(function(item, index){
                            alertify.error(errors[item][0]);
                        });
                    } else { app.handleCatch(error); }
                });
            },
            handleCatch(error) {
                app.loadDone();
                console.log(error);
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
            this.getRiwayat();
        }
    })
    </script>
@endpush