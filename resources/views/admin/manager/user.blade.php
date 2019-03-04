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
        NProgress.start();
        NProgress.set(0.4);
        // axios config
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        axios.defaults.baseURL = "{{ route('admin.manager.user.api') }}";
        var table;
        const app = new Vue({
            el: '#app',
            data: {
                nama : 'alfian dwi',
                filter: 'admin'
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
                            {data: 'id', name: 'id'},
                            {data: 'nama', name: 'nama'},
                            {data: 'email', name: 'email'},
                            {data: 'action', name: 'action'},
                        ],
                        responsive: true
                    });
                },
                detail(id){
                    NProgress.start();
                    NProgress.set(0.4);
                    axios.post('', {'action': 'detail', 'id': id}).then(function(res){
                        if (res.data.status == 'error') {
                            app.handleError(res);
                        } else {
                            setTimeout(function(){
                                NProgress.done();
                                var user = res.data.result;
                                var avatar;
                                if (user.avatar === null) {
                                    avatar = "{{ asset('assets/dist/img/avatar.png') }}";
                                } else {
                                    avatar = "{{ asset('assets/images/100x100/') }}" + user.avatar.path;
                                }
                                var html = "<div class='row'><div class='col-3'><div class='avatar'><img src='"+avatar+"' alt='...' class='img-fluid rounded-circle'></div></div><div class='col-8'><table><tr><td><b>Nama</b></td><td>: "+user.nama+"</td></tr><tr><td><b>Email</b></td><td>: "+user.email+"</td></tr><tr><td><b>Username</b></td><td>: "+user.username+"</td></tr><tr><td><b>Created at</b></td><td>: "+user.created_at+"</td></tr></table></div></div>";
                                alertify.alert('Detail User', html); 
                            }, 500);
                        }
                    });
                },
                edit(){
                    alert('halo2');
                },
                delete(){
                    alert('halo3');
                },
                handleError(res){
                    alert('Error : ' + res.data.error + ' ['+res.status+']');
                }
            },
        });
        
        app.loadTable();
    </script>
@endpush


@section('content')
    <section id="app" class="dashboard-counts no-padding-bottom">
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
                            <button v-on:click="table.ajax.reload( null, false )" title="Refresh" class="btn btn-sm btn-warning">
                                <i class="fa fa-refresh"></i>
                            </button>
                            <button v-on:click="alert('t')" title="Tambah" class="btn btn-sm btn-success">
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
@endsection

