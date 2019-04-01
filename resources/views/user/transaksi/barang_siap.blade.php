@extends('layouts.user')
@section('title', 'User \ Transaksi \ Barang Siap Keluar')
@section('page-header', 'Barang Siap Transaksi')


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
                                <th scope="col">Barang</th>
                                <th scope="col">...</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>F4Z4/0824/BAS14</td>
                                <td>VianDwi</td>
                                <td>Kirim Barang</td>
                                <td>
                                    <button class="btn btn-xs btn-primary">Lihat Detail</button>
                                </td>
                                <td>
                                    <button class="btn btn-xs btn-danger" title="Batalkan Konfirmasi" data-toggle="tooltip" data-placement="top" title="Tolak Konfirmasi">
                                        <i class="fa fa-fw fa-chevron-left"></i>
                                    </button>
                                    <button class="btn btn-xs btn-success" title="Kirim ke Penerima" data-toggle="tooltip" data-placement="top" title="Kirim ke Penerima">
                                        <i class="fa fa-fw fa-chevron-right"></i>
                                    </button>
                                    <button class="btn btn-xs btn-info" title="Detail Transaksi"  data-toggle="tooltip" data-placement="top" title="Detail Transaksi">
                                        <i class="fa fa-fw fa-info"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@stop

@push('meta')
    <meta name="api" content="{{ route('user.transaksi.barang_siap') }}">    
    <meta name="assets" content="{{ asset('assets') }}">    
@endpush

@push('js')
    <script>
    $('#sidebar-transaksi-siap').addClass('active');
    </script>
@endpush