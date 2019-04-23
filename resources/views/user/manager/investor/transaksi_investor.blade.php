@extends('layouts.user')
@section('title', 'User \ Investor')
@section('page-header', 'Transaksi Investasi')

@section('content')
<div class="row m-3 text-center" style="background: white">
        <a style="float: left" href="{{ route('user.investor.input_transaksi') }}" class="btn btn-success btn-sm mt-3 ml-3"><span class="fa fa-plus"></span> Tambah Investasi</a>
        <div class="col-md-12 col-xs-12">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible mt-3 mb-3">
                    {{session('success')}}
                </div>
            @endif
            <div class="m-3" style="display: inline inline-block">
                    <h2 class="">Tabel Investasi</h2>
                </div>
                <div class="box-body table-responsive" >
                    <table  class="table table-striped table-hover table-bordered table-align-middle text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Jumlah nominal</th>
                                <th>Tanggal Input</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($investasi->isEmpty())
                                <tr>
                                    <td colspan="4">Data masih kosong</td>
                                </tr>
                            @else
                                @php $i = 1; @endphp
                                @foreach ($investasi as $data)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td><b> {{ toRupiah($data->nominal) }} </b></td>
                                    <td><span class="label bg-info" style="font-size: 12px">{{ date('d F Y', strtotime($data->created_at)) }}</span></td>
                                    @if ($data->status == 1)
                                        <td><span class="label bg-success" style="font-size: 12px"> Sudah Diterima</span></td>
                                        @else
                                        <td><span class="label bg-danger" style="font-size: 12px"> Belum Diterima</span></td>
                                    @endif
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
@endsection
