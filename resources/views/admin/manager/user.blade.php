@extends('layouts.admin')
@section('title', 'Admin \ Manager \ User')
@section('page-header', 'Manager User')

@push('css')
    {{-- NProgress --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css">
    {{-- Alertify --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/alertify/css/alertify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/alertify/css/themes/default.min.css') }}">
    {{-- Datatables --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/af-2.3.2/b-1.5.4/b-colvis-1.5.4/b-flash-1.5.4/b-html5-1.5.4/b-print-1.5.4/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.5.0/r-2.2.2/rg-1.1.0/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
    <style>
        #nprogress .bar { height: 4px !important; }
        div.dataTables_wrapper .row { padding: 10px 5px !important; }
        @media (max-width: 768px) {
            div.dataTables_wrapper div.dataTables_filter input {
                width: 50%;
            }
        }
    </style>
@endpush

@push('js')
    {{-- NProgress --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
    {{-- Alertify --}}
    <script src="{{ asset('assets/vendor/alertify/alertify.min.js') }}"></script>
    {{-- Datatables --}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/af-2.3.2/b-1.5.4/b-colvis-1.5.4/b-flash-1.5.4/b-html5-1.5.4/b-print-1.5.4/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.5.0/r-2.2.2/rg-1.1.0/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.js"></script>
    {{-- Vue & Axios --}}
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>
    <script>
        var timeInterval = 1000;
        NProgress.start();
        NProgress.set(0.4);
        // axios config
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        axios.defaults.baseURL = "{{ route('admin.manager.user.api') }}";
        var table;
        const app = new Vue({
              data: {
          el: '#app',
                filter: 'admin',
                nama: 'tes',
                username: '',
                email: '',
                password: '',
            },
            mounted(){
                NProgress.done();
            },
            methods: {
                loadTable(){
                    var tableDOM = $('#users-table');
                    tableDOM.dataTable().fnDestroy();
                    table = tableDOM.DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '',
                            data: {filter: app.filter}
                        },
                        columns: [
                            {data: 'id'},
                            {data: 'nama'},
                            {data: 'email', searchable: true},
                            {data: 'action', orderable: false, searchable: false},
                        ],
                        responsive: true
                    });
                },
                addNew(){
                    NProgress.start();
                    NProgress.set(0.4);
                    var params = {
                        action: 'addnew',
                        nama: app.nama,
                        username: app.username,
                        email: app.email,
                        password: app.password,
                        role: app.filter
                    };

                    axios.post('', params).then(function(res){
                        if (res.data.status == 'success') {
                            alertify.success('User berhasil dibuat');
                            app.refreshTable();
                        } else {
                            alertify.error('User gagal dibuat');
                        }

                        setTimeout(function(){NProgress.done();}, timeInterval);
                    }).catch(function(error){app.handleCatch(error);});
                },
                detail(id){
                    NProgress.start();
                    NProgress.set(0.4);
                    axios.post('', {'action': 'detail', 'id': id}).then(function(res){
                        if (res.data.status == 'error') {
                            app.handleError(res);
                        } else {
                            var user = res.data.result;
                            var avatar;
                            if (user.avatar === null) {
                                avatar = "{{ asset('assets/dist/img/avatar.png') }}";
                            } else {
                                avatar = "{{ asset('assets/images/100x100/') }}" + user.avatar.path;
                            }
                            var html = "<div class='row'><div class='col-3'><div class='avatar'><img src='"+avatar+"' alt='...' class='img-fluid rounded-circle'></div></div><div class='col-8'><table><tr><td><b>Nama</b></td><td>: "+user.nama+"</td></tr><tr><td><b>Email</b></td><td>: "+user.email+"</td></tr><tr><td><b>Username</b></td><td>: "+user.username+"</td></tr><tr><td><b>Created at</b></td><td>: "+user.created_at+"</td></tr></table></div></div>";
                            alertify.alert('Detail User', html); 
                        }
                        setTimeout(function(){NProgress.done();}, timeInterval);
                    }).catch(function(error){app.handleCatch(error);});   
                },
                edit(){
                    alert('halo2');
                },
                delete(id, username){
                    var html = '<div style="text-align: center;">Yakin Akan Menghapus @' + username + '?</div>';
                    alertify.confirm('Konfirmasi', html, function(){
                        NProgress.start();
                        NProgress.set(0.4);
                        axios.post('', {'action': 'delete', 'id': id}).then(function(res){
                            if (res.status == 200 && res.data.status == 'success'){
                                alertify.success('Berhasil menghapus.');
                                app.refreshTable();
                            } else {
                                alertify.error('['+res.data.status+'] Gagal menghapus : '+'['+res.data.status+']');
                            }
                            setTimeout(function(){NProgress.done();}, timeInterval);
                        }).catch(function(error){app.handleCatch(error);});                        
                    },function(){
                        alertify.error('Batal menghapus.');
                    }).set({labels:{ok:'Hapus', cancel: 'Batal'}});
                },
                handleError(res){
                    alert('Error : ' + res.data.error + ' ['+res.status+']');
                },
                handleCatch(error) {
                    var error = error.response;
                    var errors = error.data.errors;
                    if (error.status == 422) {
                        Object.keys(errors).map(function(item, index){
                            alertify.error(errors[item][0]);
                        });
                    } else {
                        alertify.error('['+error.status+'] Error : '+'['+error.statusText+']');
                    }
                    setTimeout(function(){NProgress.done();}, timeInterval);
                },
                refreshTable(){
                    table.ajax.reload( null, false );
                }
            },
        });
        
        app.loadTable();
    </script>
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
                    <table class="table table-hover display nowrap" style="width:100%" id="users-table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Email</th>
                                <th scope="col">...</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
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
                        <input type="new-password" class="form-control" v-model="password">
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