@extends('layouts.user')
@section('title', 'User \ Halaman \ Bantuan')
@section('page-header', 'Halaman Bantuan')


@section('content')
    <section class="dashboard-counts no-padding-bottom">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                        <div style="margin-bottom: 10px;">
                            <button onclick="window.location.href = '{{ route('user.halaman.bantuan.baru') }}';" class="btn btn-success btn-sm"> <i class="fa fa-plus"></i> </button>
                        </div>

                        <div class="box-body table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Judul</th>
                                        <th>...</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Coba</td>
                                        <td>
                                            <button class="btn btn-warning btn-xs"> <i class="fa fa-edit"></i> </button>
                                            <button class="btn btn-danger btn-xs"> <i class="fa fa-trash"></i> </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@push('js')
@endpush