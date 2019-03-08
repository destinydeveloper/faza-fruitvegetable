@extends('layouts.admin')
@section('title', 'Admin \ Manager \ User')
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
    <style>
        .btn-xs, .btn-group-xs > .btn {
            padding: 0.15rem 0.4rem;
            font-size: 0.675rem;
            line-height: 1.4;
            border-radius: 0.15rem;
        }
        .btn-xs + .dropdown-toggle-split, .btn-group-xs > .btn + .dropdown-toggle-split {
            padding-right: 0.275rem;
            padding-left: 0.275rem;
        }
        #nprogress .bar { height: 4px !important; }
        div.dataTables_wrapper .row { padding: 10px 5px !important; }
        @media (max-width: 768px) {
            div.dataTables_wrapper div.dataTables_filter input {
                width: 50%;
            }
        }
    </style>
@endpush

@push('meta')
    <meta name="api" content="{{ route('admin.manager.user.api') }}">    
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
    <script src="{{ asset('assets/dist/custom/admin_manager_user.min.js') }}"></script>
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
                            <input type="new-password" class="form-control" v-model="password">
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