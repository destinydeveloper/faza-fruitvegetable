@extends('layouts.user')
@section('title', 'User \ Manager \ Gaji Karyawan')
@section('page-header', 'Manager Gaji Karyawan')

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
    <meta name="api" content="{{ route('user.manager.gajikaryawan.action') }}">    
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
                            <option value="pengepak">Pengepak</option>
                            <option value="supervisor">Supervisor</option>
                            <option value="kurir">Kurir</option>
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
                                <th scope="col">Nama</th>
                                <th scope="col">Gaji Pokok</th>
                                <th scope="col">Tunjangan</th>
                                <th scope="col">Bonus</th>
                                <th scope="col">...</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>

    {{-- Modal selectUser --}}
    <div class="modal fade" id="selectUser" tabindex="-1" role="dialog" aria-labelledby="selectUserLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="overflow-y: initial !important;" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selectUserLabel">Pilih @{{ filter }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: 60vh!important;overflow-y: auto !important;padding: 0;">
                <div class="text-center" style="margin: 10px;" v-if="getSelectUser">
                    Loading...
                </div>
                <div v-else>
                    <div class="text-center" v-if="listuserselect == null">
                        Tidak ada satupun.
                    </div>
                    <div class="list-group" v-else>
                        <a v-on:click.prevent="addnewselecteduser={id: user.id, nama: user.nama};closeModalUserSelect()" v-for="user in listuserselect" :key="user.$index" href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">@{{ user.nama }}</h5>
                                <small>@@{{ user.username }}</small>
                            </div>
                            @{{ user.email }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button v-on:click="closeModalUserSelect()" type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>                
            </div>
        </div>
    </div>
    
    {{-- Modal AddNew --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Input Gaji</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" v-on:submit.prevent="">
                    <div class="form-group">
                        <label>Nama</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" v-model="addnewselecteduserNama" disabled>
                            <div class="input-group-append">
                                <button v-on:click="openModalSelectuser()" class="btn btn-outline-secondary" type="button">Pilih @{{ filter }}</button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label>Gaji Pokok</label>
                        <input type="text" class="form-control" v-model="gaji_pokok">
                    </div>
                    <div class="form-group">
                        <label>Tunjangan</label>
                        <input type="text" class="form-control" v-model="tunjangan">
                    </div>
                    <div class="form-group">
                        <label>Bonus</label>
                        <input type="text" class="form-control" v-model="bonus">
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
                <h5 class="modal-title" id="modalEditLabel">Edit Gaji</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form" v-on:submit.prevent="">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" v-model="nama" disabled>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label>Gaji Pokok</label>
                            <input type="text" class="form-control" v-model="gaji_pokok">
                        </div>
                        <div class="form-group">
                            <label>Tunjangan</label>
                            <input type="text" class="form-control" v-model="tunjangan">
                        </div>
                        <div class="form-group">
                            <label>Bonus</label>
                            <input type="text" class="form-control" v-model="bonus">
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
    $('#sidebar-manager-gajikaryawan').addClass('active');
    // Configuration
    const loadTimeInterval = 200;
    //Jquery
    $(document).on('hidden.bs.modal','#exampleModal', function () {
        app.addnewselecteduser = null;
    });
    $(document).on('hidden.bs.modal','#modalEdit', function () {
        app.password = '';
        app.email = '';
        app.username = '';
        app.nama = '';
        app.id = '';
        app.gaji_pokok = '';
        app.tunjangan = '';
        app.bonus = '';
        app.avatar = '';
    });
    // Vue Instance
    var app = new Vue({
        el: '#app',
        data: {
            table: null,
            filter: 'pengepak',
            nama: '',
            username: '',
            email: '',
            password: '',
            avatar: '',
            showChangeAvatar: false,
            id: 0,
            gaji_pokok: null,
            tunjangan: null,
            bonus: null,
            getSelectUser: true,
            listuserselect: null,
            addnewselecteduser: null,
        },
        computed: {
            addnewselecteduserNama: function(){
                if (this.addnewselecteduser == null) {
                    return "Pilih user"
                } else {
                    return this.addnewselecteduser.nama;
                }
            },
            addnewselecteduserId: function(){
                if (this.addnewselecteduser == null) {
                    return ;
                } else {
                    return this.addnewselecteduser.id;
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
                            console.log(jqXHR);
                        }
                    },
                    columns: [
                        {data: 'no'},
                        {data: 'user.nama'},
                        {data: 'gaji_pokok'},
                        {data: 'tunjangan'},
                        {data: 'bonus'},
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
                        let user = res.data.result.user;
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
                    app.loadDone();
                    if (res.data.result === undefined) return;
                    let data = res.data.result;
                    let user = res.data.result.user;
                    app.password = '';
                    app.email = user.email;
                    app.username = user.username;
                    app.nama = user.nama;
                    app.id = data.id;
                    app.gaji_pokok = data.gaji_pokok;
                    app.tunjangan = data.tunjangan;
                    app.bonus = data.bonus;
                    app.avatar = (user.avatar === null ? assets + '/dist/img/avatar.png' : assets + "/images/100x100/" + user.avatar.path);
                    $('#modalEdit').modal('show');
                }).catch(function(error){
                    error = error.response;
                    app.loadDone();
                    app.handleCatch(error);
                });
            },
            delete(id, username) {
                console.log(username);
                let html = '<div style="text-align: center;">Yakin Akan Menghapus @' + username + '?</div>';
                alertify.confirm('Konfirmasi', html, function(){
                    app.loadStart();
                    axios.post('', {action: 'delete', 'id': id}).then(function(res){

                        if (res.data.status == 'success') {
                            alertify.success('Berhasil menghapus');
                        } else if (res.data.status == 'error') {
                            alertify.error(res.data.error);
                        } else {
                            alertify.error('Gagal menghapus');
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
                if (app.addnewselecteduser == null) {
                    alert('Pilih user yang akan ditambahkan');
                    return ;
                }
                var params = {
                    action: 'addnew',
                    id: app.addnewselecteduserId,
                    nama: app.addnewselecteduserNama,
                    gaji_pokok: app.gaji_pokok,
                    tunjangan: app.tunjangan,
                    bonus: app.bonus,
                    filter: app.filter
                };

                this.loadStart();
                axios.post('', params).then(function(res){
                    app.loadDone();
                    console.log(res);
                    if (res.data.status == 'success') {
                        alertify.success('Berhasil ditambahkan');
                        app.refreshTable();
                    } else if (res.data.status == 'error') {
                        alertify.error(res.data.error);
                    } else {
                        alertify.error('Gagal ditambahkan');
                    }
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

                app.password = '';
                app.email = '';
                app.username = '';
                app.nama = '';
                app.id = '';
                app.gaji_pokok = '';
                app.tunjangan = '';
                app.bonus = '';
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
            update() {
                var params = {
                    action: 'update',
                    nama: app.nama,
                    id: app.id,
                    gaji_pokok: app.gaji_pokok,
                    tunjangan: app.tunjangan,
                    bonus: app.bonus
                };

                this.loadStart();
                axios.post('', params).then(function(res){
                    app.loadDone();
                    if (res.data.status == 'success') {
                        alertify.success('Berhasil diperbarui');
                        app.refreshTable();
                    } else if (res.data.status == 'error') {
                        alertify.error(res.data.error);
                    } else {
                        alertify.error('Gagal diperbarui');
                    }
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
            openModalSelectuser() {
                $('#exampleModal').modal('hide');
                setTimeout(function(){ $('#selectUser').modal('show'); }, 500);
                this.loadStart();
                axios.post('', {action: 'getlistuser', 'filter': app.filter}).then(function(res){
                    app.loadDone();
                    if (res.data.status == 'success') {
                        app.listuserselect = res.data.result;
                        app.getSelectUser = false;
                    }
                    console.log(res);
                }).catch(function(error){
                    error = error.response;
                    app.loadDone();
                    app.handleCatch(error);
                });
            },
            closeModalUserSelect(){
                $('#selectUser').modal('hide');
                setTimeout(function(){ $('#exampleModal').modal('show'); }, 500);
            }
        },
        mounted(){
            this.loadTable();
        }
    });
    </script>
@endpush