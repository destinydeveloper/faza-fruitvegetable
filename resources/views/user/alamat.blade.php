@extends('layouts.user')
@section('title', 'User \ Alamat Editor')
@section('page-header', 'Alamat Editor')


@push('js')
    {{-- NProgress --}} 
    <script src="{{ asset('assets/vendor/nprogress/nprogress.min.js') }}"></script>
    {{-- Alertify --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/alertify/css/alertify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/alertify/css/themes/default.min.css') }}">
@endpush

@push('css')
    {{-- NProgress --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/nprogress/nprogress.css') }}">
    {{-- Alertify --}}
    <script src="{{ asset('assets/vendor/alertify/alertify.min.js') }}"></script>
@endpush

@section('content')
    <section class="dashboard-counts no-padding-bottom">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div style="margin-bottom: 25px;">
                        <button v-on:click="$('#exampleModal').modal('show');" class="btn btn-sm btn-success">
                            <i class="fa fa-plus"></i>
                            Buat Alamat
                        </button>
                    </div>

                    <div v-if="alamat.length == 0" style="text-align: center;">
                        <hr>
                        Tidak ada alamat satupun.
                    </div>

                    <div v-for="(item, i) in alamat" class="list-group">  
                        <a v-bind:href="item.url" class="list-group-item list-group-item-action"
                            >
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">@{{ item.alamat }} </h5>
                                <button v-on:click="deleteAlamat(item.id)" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></button>
                            </div>
                            <p class="mb-1">
                                <b>Penerima : </b> @{{ item.penerima }}
                                <span style="margin: 0 10px;">|</span>
                                <b>No. telp : </b> @{{ item.no_telp }}
                                <span style="margin: 0 10px;">|</span>
                                <b>Kodepos : </b> @{{ item.kodepos }}
                                <span style="margin: 0 10px;">|</span>
                                <b>Lengkap : </b> @{{ item.alamat_lengkap }}
                            </p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Modal AddNew --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" v-on:submit.prevent="">
                    <div class="form-group">
                        <label>Atas Nama</label>
                        <input v-model="penerima" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>No. telp</label>
                        <input v-model="no_telp" type="text" class="form-control">
                    </div>
                    <hr>
                    <div class="form-group">
                        <label>Provinsi</label>
                        <select v-on:change="getRegencies()" v-model="province" class="form-control">
                            <option v-for="(item, i) in provinces" v-bind:value="item.id">
                                @{{ item.name }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kab/Kota</label>
                        <select :disabled="regencies.length == 0" v-on:change="getDistricts()" v-model="regency" class="form-control">
                            <option v-for="(item, i) in regencies" v-bind:value="item.id">
                                @{{ item.name }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kecamatan</label>
                        <select :disabled="districts.length == 0" v-on:change="getVillages()" v-model="district" class="form-control">
                            <option v-for="(item, i) in districts" v-bind:value="item.id">
                                @{{ item.name }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Desa</label>
                        <select :disabled="villages.length == 0" v-model="village" class="form-control">
                            <option v-for="(item, i) in villages" v-bind:value="item.id">
                                @{{ item.name }}
                            </option>
                        </select>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label>Kodepos</label>
                        <input type="text" v-model="kodepos" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Alamat Lengkap</label>
                        <textarea v-model="alamat_lengkap" class="form-control"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button v-on:click="addNew()" type="button" class="btn btn-primary" data-dismiss="modal">Tambah</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
            </div>
        </div>
    </div>
@endsection

@push('meta')
    <meta name="api" content="{{ route('user.alamat') }}">    
    <meta name="assets" content="{{ asset('assets') }}">    
@endpush

@push('js')
    <script>
    $('#sidebar-alamat').addClass('active');
    // Configuration
    const loadTimeInterval = 200;
    var app = new Vue({
        el: '#app',
        data: {
            provinces: [],
            regencies: [],
            districts: [],
            villages: [],
            province: null,
            regency: null,
            district: null,
            village: null,
            penerima: '',
            no_telp: '',
            kodepos: '',
            alamat_lengkap: '',

            alamat: []
        },
        methods: {
            loadStart(){
                NProgress.start();
                NProgress.set(0.4);
            },
            loadDone(){
                setTimeout(function(){NProgress.done();}, loadTimeInterval);
            },
            loadProvinces: function(){
                if (app ===  undefined) { this.loadStart(); } else { app.loadStart(); }
                axios.post('', {action: 'getprovinces'}).then(function(res){
                    if (app ===  undefined) { this.loadDone(); } else { app.loadDone(); }
                    if (res.data.status == 'success') {
                        app.provinces = res.data.result;
                    } else {
                        $('#modalExample').modal('hide');
                    }
                });
            },
            getRegencies: function(){
                if (app ===  undefined) { this.loadStart(); } else { app.loadStart(); }
                
                app.districts = [];
                app.villages = [];

                axios.post('', {action: 'getregencies', id: app.province}).then(function(res){
                    if (app ===  undefined) { this.loadDone(); } else { app.loadDone(); }    
                    if (res.data.status == 'success') {
                        app.regencies = res.data.result;
                    } else {
                        $('#modalExample').modal('hide');
                    }

                });
            },
            getDistricts: function(){
                if (app ===  undefined) { this.loadStart(); } else { app.loadStart(); }
                
                app.villages = [];
                
                axios.post('', {action: 'getdistrict', id: app.regency}).then(function(res){
                    if (app ===  undefined) { this.loadDone(); } else { app.loadDone(); } 
                    if (res.data.status == 'success') {
                        app.districts = res.data.result; 
                    } else {
                        $('#modalExample').modal('hide');
                    }
                });
            },
            getVillages: function(){
                if (app ===  undefined) { this.loadStart(); } else { app.loadStart(); }
                axios.post('', {action: 'getvillage', id: app.district}).then(function(res){
                    if (app ===  undefined) { this.loadDone(); } else { app.loadDone(); } 
                    if (res.data.status == 'success') {
                        app.villages = res.data.result;
                    } else {
                        $('#modalExample').modal('hide');
                    }
                });
            },
            addNew: function (){
                let params = {
                    action: 'addnew',
                    penerima: app.penerima,
                    no_telp: app.no_telp,
                    village: app.village,
                    kodepos: app.kodepos,
                    alamat_lengkap: app.alamat_lengkap,
                };

                app.loadStart();
                axios.post('', params).then(function(res){
                    app.loadDone(); 
                    if (res.data.status == 'success') {
                        alertify.success("Berhasil dibuat");
                        app.getAlamat();
                    } else {
                        $('#modalExample').modal('hide');
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
            handleCatch: function(error) {
                app.loadDone();
                if (error.status == 500) {
                    alertify.error('Server Error, Try again later');
                } else if (error.status == 422) {
                    alertify.error('Form invalid, Check input form');
                } else {
                    alertify.error('['+error.status+'] Error : '+'['+error.statusText+']');
                }
            },
            getAlamat: function(){
                if (app ===  undefined) { this.loadStart(); } else { app.loadStart(); } 
                axios.get('').then(function(res){
                    if (res.data.status == 'success') {
                        app.alamat = res.data.result;
                    }
                    if (app ===  undefined) { this.loadDone(); } else { app.loadDone(); } 
                }).catch(function(error){
                    error = error.response;
                    app.loadDone();
                    app.handleCatch(error);
                });
            },
            deleteAlamat: function(id){
                app.loadStart();
                axios.post('', {action: 'delete', 'id': id}).then(function(res){
                    if (res.data.status == 'success') {
                        app.getAlamat();
                        alertify.success("Berhasil dihapus");
                    }
                    app.loadDone();
                }).catch(function(error){
                });
            }
        },
        mounted(){
            this.getAlamat();
            this.loadProvinces();
        }
    });
    </script>    
@endpush