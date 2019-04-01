@extends('layouts.user')
@section('title', 'User \ Transaksi \ Trace & Track')
@section('page-header', 'Trace & Track Transaksi')


@section('content')
    <section class="dashboard-counts no-padding-bottom">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    
                        <form v-on:submit.prevent="" class="form-inline" style="margin-bottom: 15px;">
                                <label style="margin-right: 10px;" for="filter">Filter : </label>
                                <select v-on:change="loadTable()" v-model="filter" class="form-control" id="filter">
                                    <option value="semua">Semua</option>
                                    <option value="kirim">Kirim Barang</option>
                                    <option value="cod">COD</option>
                                </select>
                                <span style="margin-left: 10px;">
                                    <button v-on:click="refreshTable()" title="Refresh" class="btn btn-sm btn-warning">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                </span>
                            </form>
                            <table class="table table-sm table-hover display nowrap" style="width:100%" id="permintaan">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Kode</th>
                                        <th scope="col">User</th>
                                        <th scope="col">Metode</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">...</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <td>1</td>
                                    <td>F4Z4/0824/BAS14</td>
                                    <td>VianDwi</td>
                                    <td>Kirim Barang</td>
                                    <td>
                                        [JNE] Menerima Paket
                                    </td>
                                    <td>
                                        <button class="btn btn-xs btn-warning" title="Edit Status" data-toggle="tooltip" data-placement="top" title="Edit Status">
                                            <i class="fa fa-fw fa-edit"></i>
                                        </button>
                                        <button class="btn btn-xs btn-info" title="Detail Transaksi" data-toggle="tooltip" data-placement="top" title="Detail Transaksi">
                                            <i class="fa fa-fw fa-info"></i>
                                        </button>
                                    </td>
                                </tbody>
                            </table>
                            
                            <div style="margin-top: 25px;">
                                <span>
                                    * Status dari pihak ketiga (ekspedisi) akan otomatis
                                    memperbarui dalam beberapa menit.
                                </span>
                            </div>
                    
                </div>
            </div>
        </div>
    </section>
@stop

@push('meta')
    <meta name="api" content="{{ route('user.transaksi.trace_track') }}">    
    <meta name="assets" content="{{ asset('assets') }}">    
@endpush

@push('js')
    <script>
    $('#sidebar-transaksi-track').addClass('active');
    </script>
@endpush