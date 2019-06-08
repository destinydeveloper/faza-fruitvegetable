@extends('layouts.user')
@section('title', 'User \ Manager \ Barang')
@section('page-header', 'Manager Barang')

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
    <meta name="api" content="{{ route('user.manager.barang.action') }}">    
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
                    <form v-on:submit.prevent="" class="form-inline" style="margin-bottom: 15px;">
                        <label style="margin-right: 10px;" for="filter">Filter : </label>
                        <select v-on:change="loadTable()" v-model="filter" class="form-control" id="filter">
                            <option value="semua">Semua</option>
                            <option value="sayur">Sayur</option>
                            <option value="buah">Buah</option>
                        </select>
                        <span style="margin-left: 10px;">
                            <button v-on:click="refreshTable()" title="Refresh" class="btn btn-sm btn-warning">
                                <i class="fa fa-refresh"></i>
                            </button>
                            <button data-toggle="modal" data-target="#exampleModal" title="Tambah" class="btn btn-sm btn-success">
                                <i class="fa fa-plus"></i>
                            </button>
                        </span>
                    </form>
                    <table class="table table-sm table-hover display nowrap" style="width:100%" id="barang-table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Jenis</th>
                                <th scope="col">Stok</th>
                                <th scope="col">Berat</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Status</th>
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
            <div class="modal-body" style="padding: 0;">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="informasi-tab" data-toggle="tab" href="#informasi" role="tab" aria-controls="informasi" aria-selected="true">Informasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="gambar-tab" data-toggle="tab" href="#gambar" role="tab" aria-controls="gambar" aria-selected="false">Gambar</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent" style="padding: 25px;">
                    <div class="tab-pane fade show active" id="informasi" role="tabpanel" aria-labelledby="informasi-tab">
                        <form class="form" v-on:submit.prevent="">
                            <div class="form-group">
                                <label>Nama</label>
                                <input v-model="nama" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Jenis</label>
                                <select v-model="jenis" class="form-control">
                                    <option>---- Pilih ----</option>
                                    <option value="sayur">Sayur</option>
                                    <option value="buah">Buah</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Harga</label>
                                <input v-model="harga" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Berat</label>
                                <div class="form-row">
                                    <div class="form-group col-md-8">
                                        <input v-model="berat" type="text" class="form-control" placeholder="Berat">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <input v-bind:value="satuan_berat" type="text" class="form-control" placeholder="Satuan..kg,gram" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Stok</label>
                                <div class="form-row">
                                    <div class="form-group col-md-8">
                                        <input v-model="stok" type="text" class="form-control" placeholder="Stok">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <input v-model="satuan_stok" type="text" class="form-control" placeholder="Satuan..sak,stok,bungkus">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="gambar" role="tabpanel" aria-labelledby="gambar-tab">
                        <button v-on:click="$refs.file.click()" class="btn btn-sm btn-success">
                            <i class="fa fa-plus"></i> Tambah Gambar
                        </button>
                        <span style="float: right;">@{{ images.length }} Gambar</span>
                        <input style="display: none;" ref="file" type="file" multiple="multiple" id="imageNew" v-on:change="uploadImageChangeNew">
                        <hr>
                        <div id="previewImageNew" style="text-align: center;max-height: 40vh;overflow-y: auto;">
                            
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

    {{-- Modal Edit --}}
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 0;">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="informasiEdit-tab" data-toggle="tab" href="#informasiEdit" role="tabEdit" aria-controls="informasi" aria-selected="true">Informasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="gambarEdit-tab" data-toggle="tab" href="#gambarEdit" role="tab" aria-controls="gambarEdit" aria-selected="false">Gambar</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent" style="padding: 25px;">
                    <div class="tab-pane fade show active" id="informasiEdit" role="tabpanel" aria-labelledby="informasiEdit-tab">
                        <form class="form" v-on:submit.prevent="">
                            <div class="form-group">
                                <label>Nama</label>
                                <input v-model="nama" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select v-model="status" class="form-control">
                                    <option value="1">Ditampilkan</option>
                                    <option value="0">Disembunyikan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Jenis</label>
                                <select v-model="jenis" class="form-control">
                                    <option value="sayur">Sayur</option>
                                    <option value="buah">Buah</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Harga</label>
                                <input v-model="harga" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Berat</label>
                                <div class="form-row">
                                    <div class="form-group col-md-8">
                                        <input v-model="berat" type="text" class="form-control" placeholder="Berat">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <input v-bind:value="satuan_berat" type="text" class="form-control" placeholder="Satuan..kg,gram" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Stok</label>
                                <div class="form-row">
                                    <div class="form-group col-md-8">
                                        <input v-model="stok" type="text" class="form-control" placeholder="Stok">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <input v-model="satuan_stok" type="text" class="form-control" placeholder="Satuan..sak,stok,bungkus">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="gambarEdit" role="tabpanel" aria-labelledby="gambarEdit-tab">
                        <button v-on:click="$refs.fileEdit.click()" class="btn btn-sm btn-success">
                            <i class="fa fa-plus"></i> Tambah Gambar
                        </button>
                        <span style="float: right;">@{{ images.length + imagesEdit.length }} Gambar</span>
                        <input style="display: none;" ref="fileEdit" type="file" multiple="multiple" id="imageEdit" v-on:change="uploadImageChangeEdit">
                        <hr>
                        <div id="previewImageEdit" style="text-align: center;max-height: 40vh;overflow-y: auto;">
                            
                        </div>
                    </div>

                </div>                
            </div>
            <div class="modal-footer">
                <button v-on:click="update()" type="button" class="btn btn-primary" data-dismiss="modal">Tambah</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
            </div>
        </div>
    </div>
@stop

@push('js')
    <script>
    $('#sidebar-manager-barang').addClass('active');
    // Configuration
    const loadTimeInterval = 200;
    // Vue Instance
    var app = new Vue({
        el: '#app',
        data: {
            filter: 'semua',
            images: [],
            imagesEdit: [],
            addNewData: new FormData(),
            addEditData: new FormData(),

            nama: '',
            jenis: '',
            harga: '',
            berat: '',
            stok: '',
            satuan_berat: 'gram',
            satuan_stok: '',
            id: null,
            status: '',
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
                        {data: 'nama'},
                        {data: 'jenis'},
                        {data: 'stok'},
                        {data: 'berat'},
                        {data: 'harga'},
                        {data: 'status'},
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
            uploadImageChangeNew(e){
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                for (var i = files.length - 1; i >= 0; i--) {
                    this.images.push(files[i]);
                }
                document.getElementById("imageNew").value = [];
                this.reloadPeviewImageNew();
            },
            reloadPeviewImageNew(){
                //previewImageNew
                var files = this.images;
                $('#previewImageNew').html('');
                this.addNewData = new FormData();
                this.addNewData.append('nama', 'alfian dwi');
                var previewImageNew = $('#previewImageNew');
                for (var i = files.length - 1; i >= 0; i--) {
                    this.addNewData.append('images[]', files[i]);
                    let url = URL.createObjectURL(files[i]);
                    var action = "app.images.splice(app.images.indexOf("+i+"), 1);app.reloadPeviewImageNew();";
                    var html = $('<div class="thumb-image" style="margin-bottom: 10px;position: relative;"><button onclick="'+action+'" class="btn btn-danger btn-sm" style="border-radius: 50%;position: absolute;margin: 5px;"><i class="fa fa-times"></i></button><img class="image" style="max-height: 100px;" id="imgPreviewThumbnailNew'+i+'"></div>');
                    $('#previewImageNew').append(html);
                    $('#imgPreviewThumbnailNew'+i).attr('src', url);
                }
            },
            handleCatch(error){
                app.loadDone();
                if (error.status == 500) {
                    alertify.error('Server Error, Try again later');
                } else if (error.status == 422) {
                    alertify.error('Form invalid, Check input form');
                } else {
                    alertify.error('['+error.status+'] Error : '+'['+error.statusText+']');
                }
            },
            addNew(){
                this.addNewData.append('action', 'addnew');
                this.addNewData.append('nama', this.nama);
                this.addNewData.append('jenis', this.jenis);
                this.addNewData.append('harga', this.harga);
                this.addNewData.append('berat', this.berat);
                this.addNewData.append('stok', this.stok);
                this.addNewData.append('satuan_berat', this.satuan_berat);
                this.addNewData.append('satuan_stok', this.satuan_stok);

                app.loadStart();
                axios.post('', this.addNewData, { headers: { 'Content-Type': 'multipart/form-data' } }).then(function(res){
                    if (res.data.status == 'success') {
                        alertify.success('Berhasil menambahkan');
                    } else if (res.data.status == 'error') {
                        alertify.error(res.data.error);
                    } else {
                        alertify.error('Gagal menambahkan');
                    }
                    app.refreshTable();
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
            randomInt() {
                return Math.random();
            },
            detail(id) {
                app.loadStart();
                axios.post('', { action: 'detail', 'id': id }).then(function(res){
                    app.loadDone();
                    let barang = res.data.result;
                    let gambar = '';

                    barang.gambar.forEach(function(item){
                        gambar = gambar + '<img style="max-height: 100px;margin: 5px;" src="'+assets+'/images/original/'+item.path+'?cache='+app.randomInt()+'">';
                    });

                    if (barang.gambar.length == 0 || barang.gambar === undefined) {
                        gambar = '<div style="text-align: center;">Tidak ada gambar.</div>'
                    } else {
                        gambar = '<div style="display: flex;flex-wrap: nowrap;overflow-x: scroll">'+gambar+'</div>';
                    }

                    let html = '<div>'+gambar+'<hr><table><tr><td><b>ID</b></td><td> : '+barang.id+'</td></tr><tr><td><b>Nama</b></td><td> : '+barang.nama+'</td></tr><tr><td><b>Jenis</b></td><td> : '+ barang.jenis.charAt(0).toUpperCase() + barang.jenis.slice(1) +'</td></tr><tr><td><b>Harga</b></td><td> : '+ (app.rupiah(barang.harga)) +'</td></tr><tr><td><b>Berat</b></td><td> : '+barang.berat+' '+barang.satuan_berat+'</td></tr><tr><td><b>Stok</b></td><td> : '+barang.stok+' '+barang.satuan_stok+'</td></tr><tr><td><b>Status</b></td><td> : '+ (barang.status == 1 ? 'Ditampilkan' : 'Disembunyikan') +'</td></tr></table></div>';
                    alertify.alert('Detail Barang', html); 
                }).catch(function(error){
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
            delete(id, nama) {
                let html = '<div style="text-align: center;">Yakin Akan Menghapus @' + nama + '?</div>';
                alertify.confirm('Konfirmasi', html, function(){
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
            edit(id) {
                app.imagesEdit = [];
                app.images = [];

                app.loadStart();
                axios.post('', { action: 'detail', 'id': id }).then(function(res){
                    app.loadDone();
                    let barang = res.data.result;
                    let gambar = '';

                    app.imagesEdit = barang.gambar;
                    app.nama = barang.nama;
                    app.jenis = barang.jenis;
                    app.id = barang.id;
                    app.harga = barang.harga;
                    app.berat = barang.berat;
                    app.stok = barang.stok;
                    app.satuan_berat = barang.satuan_berat;
                    app.satuan_stok = barang.satuan_stok;
                    app.status = barang.status;


                    app.reloadPeviewImageEdit();
                    $('#editModal').modal('show');
                }).catch(function(error){
                    error = error.response;
                    app.loadDone();
                    app.handleCatch(error);
                });
            },
            uploadImageChangeEdit(e){
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                for (var i = files.length - 1; i >= 0; i--) {
                    app.images.push(files[i]);
                }
                document.getElementById("imageEdit").value = [];
                app.reloadPeviewImageEdit();
            },
            reloadPeviewImageEdit(){
                //previewImageNew
                $('#previewImageEdit').html('');
                // for (var i = app.imagesEdit.length - 1; i >= 0; i--) {
                for (var i = 0; i <= app.imagesEdit.length - 1; i++) {
                    var action = "app.imagesEdit.splice("+i+", 1);app.reloadPeviewImageEdit();";
                    var html = $('<div class="thumb-image" style="margin-bottom: 10px;position: relative;"><button onclick="'+action+'" class="btn btn-danger btn-sm" style="border-radius: 50%;position: absolute;margin: 5px;"><i class="fa fa-times"></i></button><img class="image" style="max-height: 100px;" id="imgPreviewThumbnailEdit'+i+'"></div>');
                    $('#previewImageEdit').append(html);
                    let url = assets + '/images/original/' + app.imagesEdit[i].path;
                    $('#imgPreviewThumbnailEdit'+i).attr('src', url);
                }
                var files = this.images;
                $('#previewImageNew').html('');
                this.addEditData = new FormData();
                this.addEditData.append('nama', 'alfian dwi');
                var previewImageNew = $('#previewImageNew');
                for (var i = app.imagesEdit.length; i < (app.imagesEdit.length + files.length); i++ ) {
                    let j = (i-(app.imagesEdit.length));
                    this.addEditData.append('images[]', files[j]);
                    let url = URL.createObjectURL(files[j]);
                    var action = "app.images.splice("+ j +", 1);app.reloadPeviewImageEdit();";
                    var html = $('<div class="thumb-image" style="margin-bottom: 10px;position: relative;"><button onclick="'+action+'" class="btn btn-danger btn-sm" style="border-radius: 50%;position: absolute;margin: 5px;"><i class="fa fa-times"></i></button><img class="image" style="max-height: 100px;" id="imgPreviewThumbnailEdit'+i+'"></div>');
                    $('#previewImageEdit').append(html);
                    $('#imgPreviewThumbnailEdit'+i).attr('src', url);
                }
            },
            update(){
                app.addEditData.append('action', 'update');
                app.addEditData.append('id', app.id);
                app.addEditData.append('nama', app.nama);
                app.addEditData.append('jenis', app.jenis);
                app.addEditData.append('harga', app.harga);
                app.addEditData.append('berat', app.berat);
                app.addEditData.append('stok', app.stok);
                app.addEditData.append('satuan_berat', app.satuan_berat);
                app.addEditData.append('satuan_stok', app.satuan_stok);
                app.addEditData.append('status', app.status);

                app.imagesEdit.forEach(function(item) {
                    app.addEditData.append('images_old[]', item.id);
                });


                app.loadStart();
                axios.post('', this.addEditData, { headers: { 'Content-Type': 'multipart/form-data' } }).then(function(res){
                    console.log(res);
                    if (res.data.status == 'success') {
                        alertify.success('Berhasil memperbarui');
                    } else if (res.data.status == 'error') {
                        alertify.error(res.data.error);
                    } else {
                        alertify.error('Gagal memperbarui');
                    }
                    app.refreshTable();
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
        },
        mounted(){
            this.loadTable();
        }
    });
    </script>
@endpush