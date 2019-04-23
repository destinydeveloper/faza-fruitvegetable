@extends('layouts.user')
@section('title', 'User \ Manager \ User')
@section('page-header', 'Manager User')

@push('css')
    {{-- NProgress --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/nprogress/nprogress.css') }}">
    {{-- DataTables Bootstrap --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/responsive.dataTables.min.css') }}">
    {{-- Alertify --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/alertify/css/alertify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/alertify/css/themes/default.min.css') }}">
    {{-- Custom --}}
@endpush

@push('meta')
    <meta name="api" content="{{ route('user.manager.user.action') }}">
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
    {{-- <script src="{{ asset('assets/dist/custom/admin_manager_user.min.js') }}"></script> --}}
@endpush


@section('content')
    <section class="dashboard-counts no-padding-bottom">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form v-on:submit.prevent="" class="form-inline" style="margin-bottom: 15px;">
                        <label style="margin-right: 10px;" for="filter">Filter : </label>
                        <select v-on:change="loadTable()" v-model="filter" class="form-control" id="filter">
                            <option value="admin">Admin</option>
                            <option value="investor">Investor</option>
                            <option value="pengepak">Pengepak</option>
                            <option value="supervisor">Supervisor</option>
                            <option value="kurir">Kurir</option>
                            <option value="pelanggan">Pelanggan</option>
                            <option value="petani">Petani</option>
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
                    <table class="table table-sm table-hover display nowrap" style="width:100%" id="users-table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ID</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Username</th>
                                <th scope="col">Email</th>
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah @{{ filter }}</h5>
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
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" v-model="username">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" v-model="email">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" v-model="password">
                            <div class="input-group-append">
                                <button v-on:click="generateSafePassword()" class="btn btn-outline-secondary" type="button">Generate</button>
                            </div>
                        </div>
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

    {{-- Modal Edit --}}
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel">Edit @@{{ username }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form" v-on:submit.prevent="">
                        {{-- <div class="form-group" style="text-align: center;">
                            <div class='avatar' style="position: relative;">
                                <img v-on:mouseover="showChangeAvatar = true" v-on:mouseleave="showChangeAvatar = false" v-bind:src="avatar" alt='Avatar' class='img-fluid rounded-circle'>
                                <div style="text-grey" v-if="showChangeAvatar">Click to change avatar</div>
                            </div>
                        </div>
                        <input id="image" type="file" v-on:change="alert('image change')">
                        <hr> --}}
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" v-model="nama">
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" v-model="username">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                        <input type="text" class="form-control" v-model="email">
                        </div>
                        <hr>
                        <div class="form-group">
                            <label>Ganti Password</label>
                            <div class="input-group mb-3">
                                <input type="new-password" class="form-control" v-model="password">
                                <div class="input-group-append">
                                        <button v-on:click="generateSafePassword()" class="btn btn-outline-secondary" type="button">Generate</button>
                                        <button v-on:click="password = ''" class="btn btn-outline-secondary" type="button">blank</button>
                                </div>
                                <span class="text-grey">*nb : Biarkan kosong jika tidak bermaksud mengganti password</span>
                            </div>
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
    $('#sidebar-manager-user').addClass('active');
    // Configuration
    const loadTimeInterval = 200;
    // Jquery
    // Vue Instance
    var app = new Vue({
        el: '#app',
        data: {
            table: null,
            filter: 'admin',
            nama: '',
            username: '',
            email: '',
            password: '',
            avatar: '',
            showChangeAvatar: false,
            id: 0,
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
                $('#users-table').dataTable().fnDestroy();
                this.table = $('#users-table').DataTable({
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
                        {data: 'id'},
                        {data: 'nama'},
                        {data: 'username'},
                        {data: 'email', searchable: true},
                        {data: 'action', orderable: false, searchable: false},
                    ],
                    responsive: true,
                    drawCallback: function( settings ) {
                        app.loadDone();
                    },
                });
                $('#users-table').on( 'search.dt', function (e, settings) {
                    if (app ===  undefined) { this.loadStart(); } else { app.loadStart(); }
                });
            },
            refreshTable(){
                this.table.ajax.reload( null, false );
            },
            detail(id){
                this.loadStart();
                axios.post('', {action: 'detail', 'id': id}).then(function(res){
                    if (res.data.status == 'success') {
                        let user = res.data.result;
                        let avatar = (user.avatar === null ? assets + '/dist/img/avatar.png' : assets + "/images/100x100/" + user.avatar.path);
                        let html = "<div class='row'><div class='col-3'><div class='avatar'><img src='"+avatar+"' alt='...' class='img-fluid rounded-circle'></div></div><div class='col-8'><table><tr><td><b>ID</b></td><td> : "+user.id+"</td></tr><tr><td><b>Nama</b></td><td> : "+user.nama+"</td></tr><tr><td><b>Email</b></td><td> : "+user.email+"</td></tr><tr><td><b>Username</b></td><td> : "+user.username+"</td></tr><tr><td><b>Created at</b></td><td> : "+user.created_at+"</td></tr></table></div></div>";
                        alertify.alert('Detail User', html);
                    }
                    app.loadDone();
                }).catch(function(error){
                    error = error.response;
                    app.loadDone();
                    app.handleCatch(error);
                });
            },
            edit(id) {
                this.loadStart();
                axios.post('', {action: 'detail', 'id': id}).then(function(res){
                    let user = res.data.result;
                    app.password = '';
                    app.email = user.email;
                    app.username = user.username;
                    app.nama = user.nama;
                    app.id = user.id;
                    app.avatar = (user.avatar === null ? assets + '/dist/img/avatar.png' : assets + "/images/100x100/" + user.avatar.path);
                    $('#modalEdit').modal('show');
                    app.loadDone();
                }).catch(function(error){
                    error = error.response;
                    app.loadDone();
                    app.handleCatch(error);
                });
            },
            delete(id, username) {
                let html = '<div style="text-align: center;">Yakin Akan Menghapus @' + username + '?</div>';
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
            addNew(){
                var params = {
                    action: 'addnew',
                    nama: app.nama,
                    username: app.username,
                    email: app.email,
                    password: app.password,
                    role: app.filter
                };

                this.loadStart();
                axios.post('', params).then(function(res){
                    app.loadDone();
                    if (res.data.status == 'success') {
                        alertify.success('User berhasil dibuat');
                        app.refreshTable();
                    } else {
                        alertify.error('User gagal dibuat');
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

                app.password = '';
                app.email = '';
                app.username = '';
                app.nama = '';
                app.id = '';
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
            update() {
                var params = {
                    action: 'update',
                    nama: app.nama,
                    username: app.username,
                    email: app.email,
                    password: app.password,
                    id: app.id,
                };

                this.loadStart();
                axios.post('', params).then(function(res){
                    app.loadDone();
                    if (res.data.status == 'success') {
                        alertify.success('@'+res.data.result.username+' berhasil diperbarui');
                        app.refreshTable();
                    } else {
                        alertify.error('@'+res.data.result.username+' gagal diperbarui');
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
            generateSafePassword() {
                // var specials = '!@#$%^&*()_+{}:"<>?\|[];\',./`~';
                var lowercase = 'abcdefghijklmnopqrstuvwxyz';
                var uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                var numbers = '0123456789';
                var all = lowercase + uppercase + numbers;
                String.prototype.pick = function(min, max) {
                    var n, chars = '';
                    if (typeof max === 'undefined') {
                        n = min;
                    } else {
                        n = min + Math.floor(Math.random() * (max - min));
                    }
                    for (var i = 0; i < n; i++) {
                        chars += this.charAt(Math.floor(Math.random() * this.length));
                    }
                    return chars;
                };
                String.prototype.shuffle = function() {
                    var array = this.split('');
                    var tmp, current, top = array.length;
                    if (top) while (--top) {
                        current = Math.floor(Math.random() * (top + 1));
                        tmp = array[current];
                        array[current] = array[top];
                        array[top] = tmp;
                    }
                    return array.join('');
                };
                var password = (lowercase.pick(1) + uppercase.pick(1) + all.pick(3, 10)).shuffle();
                this.password = password;
            }
        },
        mounted(){
            this.loadTable();
        }
    });
    </script>
@endpush
