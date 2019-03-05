@extends('layouts.admin')


@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/af-2.3.2/b-1.5.4/b-colvis-1.5.4/b-flash-1.5.4/b-html5-1.5.4/b-print-1.5.4/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.5.0/r-2.2.2/rg-1.1.0/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">

    {{-- Alertify --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/alertify/css/alertify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/alertify/css/themes/default.min.css') }}">
@endpush

@push('js')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/af-2.3.2/b-1.5.4/b-colvis-1.5.4/b-flash-1.5.4/b-html5-1.5.4/b-print-1.5.4/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.5.0/r-2.2.2/rg-1.1.0/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.js"></script>
    
    {{-- Alertify --}}
    <script src="{{ asset('assets/vendor/alertify/alertify.min.js') }}"></script>

    {{-- Vue & Axios --}}
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>

    <script>
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        axios.defaults.baseURL = "{{ route('admin.manager.user.api') }}";

        var app = new Vue({
            el: '#app',
            data: {
                table: null,
                filter: 'admin',
                nama: '',
                username: '',
                email: '',
                password: '',
            },
            methods: {
                loadTable(){
                    $('#users-table').dataTable().fnDestroy();
                    this.table = $('#users-table').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '',
                            data: { filter: this.filter }
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
                refreshTable(){
                    this.table.ajax.reload( null, false );
                },
                detail(id){
                    axios.post('', {action: 'detail', 'id': id}).then(function(res){
                        if (res.data.status == 'success') {
                            let user = res.data.result;
                            let avatar = (user.avatar === null ? "{{ asset('assets/dist/img/avatar.png') }}" : "{{ asset('assets/images/100x100/') }}" + user.avatar.path);
                            let html = "<div class='row'><div class='col-3'><div class='avatar'><img src='"+avatar+"' alt='...' class='img-fluid rounded-circle'></div></div><div class='col-8'><table><tr><td><b>Nama</b></td><td>: "+user.nama+"</td></tr><tr><td><b>Email</b></td><td>: "+user.email+"</td></tr><tr><td><b>Username</b></td><td>: "+user.username+"</td></tr><tr><td><b>Created at</b></td><td>: "+user.created_at+"</td></tr></table></div></div>";
                            alertify.alert('Detail User', html); 
                        }
                    });
                },
                delete(id, username) {
                    let html = '<div style="text-align: center;">Yakin Akan Menghapus @' + username + '?</div>';
                    alertify.confirm('Konfirmasi', html, function(){
                        axios.post('', {action: 'delete', 'id': id}).then(function(res){
                            if (res.data.status == 'success') {
                                alertify.success('Berhasil menghapus');
                            }
                            app.refreshTable();
                        });                      
                    },function(){
                        alertify.error('batal menghapus.');
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

                    axios.post('', params).then(function(res){
                        if (res.data.status == 'success') {
                            alertify.success('User berhasil dibuat');
                            app.refreshTable();
                        } else {
                            alertify.error('User gagal dibuat');
                        }
                    });
                }
            },
            mounted(){
                this.loadTable();
            }
        });
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
@stop