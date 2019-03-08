@extends('layouts.admin')
@section('title', 'Admin \ Profil')
@section('page-header', 'Profil')

@push('css')
    <style>
        .form-group.row {
            padding: 5px !important;
            margin: 0;
        }
    </style>    
@endpush

@section('content')
    <section class="dashboard-counts no-padding-bottom">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div style="text-align: center;">
                        <div class="avatar"><img src="{{ Auth()->user()->avatar === null ? asset('assets/dist/img/avatar.png') : asset('assets/images/100x100/'.Auth()->user()->avatar->path) }}" title="{{ Auth()->user()->avatar->judul }}" alt="{{ Auth()->user()->avatar->judul }}" class="img-fluid rounded-circle"></div>
                        <hr>
                    </div>
                    @if(Session::has('message'))
                        <div class="alert alert-{{ Session::get('message')[0] }}">
                            {{ Session::get('message')[1] }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul style="margin:0;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="profil">
                        <div class="form-group row">
                            <label for="colFormLabelSm" class="col-2 col-form-label col-form-label-sm">Nama</label>
                            <div class="col-sm-10">
                            <input name="nama" type="text" class="form-control form-control-sm" value="{{ Auth()->user()->nama }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="colFormLabelSm" class="col-2 col-form-label col-form-label-sm">Username</label>
                            <div class="col-sm-10">
                                <input name="username" type="text" class="form-control form-control-sm " value="{{ Auth()->user()->username }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="colFormLabelSm" class="col-2 col-form-label col-form-label-sm">Email</label>
                            <div class="col-sm-10">
                                <input name="email" type="email" class="form-control form-control-sm" value="{{ Auth()->user()->email }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="colFormLabelSm" class="col-2 col-form-label col-form-label-sm">Upload Avatar</label>
                            <div class="col-sm-10">
                                <input name="avatar" type="file" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <span class="float-right">
                                    <button type="submit" class="btn btn-primary">Perbarui</button>
                                </span>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <form method="POST">
                        @csrf
                        <input type="hidden" name="change_password">
                        <div class="form-group row">
                            <label for="colFormLabelSm" class="col-2 col-form-label col-form-label-sm">Password</label>
                            <div class="col-sm-10">
                                <input name="password" type="password" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="colFormLabelSm" class="col-2 col-form-label col-form-label-sm">Re-Password</label>
                            <div class="col-sm-10">
                                <input name="re_password" type="password" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <span class="float-right">
                                    <button type="submit" class="btn btn-secondary">Ganti Password</button>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection


@push('js')
    <script>$('#sidebar-profil').addClass('active');</script>    
@endpush