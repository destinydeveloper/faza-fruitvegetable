@extends('layouts.user')
@section('title', 'User \ Investor')
@section('page-header', 'Laporan Keuangan')

@section('content')
    <div class="row m-3 text-center">
        <div class="col-md-12 col-xs-12" style="background: white;">
            <div class="m-3" style="display: inline">
                {{-- @if (session('error'))
                <div class="alert alert-danger alert-dismissible">
                    Harap memilih periode dengan benar
                </div>
                @endif --}}
                @if (session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    Harap memilih periode dengan benar
                </div>
                @endif
                <h2 class="">Tabel Laporan Keuangan</h2>
                <div class="float-left text-left">
                    <form action="#" method="get">
                        <label for="bulan">Periode</label>
                        <div class="form-inline mb-3">
                            <select name="bulan" id="bulan" class="form-control" required>
                                <option value="">Pilih bulan</option>
                                <option value="1" {{ Request::get('bulan') == 1 ? 'selected' : '' }}>Januari</option>
                                <option value="2" {{ Request::get('bulan') == 2 ? 'selected' : '' }}>Pebruari</option>
                                <option value="3" {{ Request::get('bulan') == 3 ? 'selected' : '' }}>Maret</option>
                                <option value="4" {{ Request::get('bulan') == 4 ? 'selected' : '' }}>April</option>
                                <option value="5" {{ Request::get('bulan') == 5 ? 'selected' : '' }}>Mei</option>
                                <option value="6" {{ Request::get('bulan') == 6 ? 'selected' : '' }}>Juni</option>
                                <option value="7" {{ Request::get('bulan') == 7 ? 'selected' : '' }}>Juli</option>
                                <option value="8" {{ Request::get('bulan') == 8 ? 'selected' : '' }}>Agustus</option>
                                <option value="9" {{ Request::get('bulan') == 9 ? 'selected' : '' }}>September</option>
                                <option value="10" {{ Request::get('bulan') == 10 ? 'selected' : '' }}>Oktober</option>
                                <option value="11" {{ Request::get('bulan') == 11 ? 'selected' : '' }}>Nopember</option>
                                <option value="12" {{ Request::get('bulan') == 12 ? 'selected' : '' }}>Desember</option>
                            </select>

                            <select name="tahun" id="bulan" class="form-control" required>
                                <option value="">Pilih tahun</option>
                                <option value="2019" {{ Request::get('tahun') == 2019 ? 'selected' : '' }}>2019</option>
                                <option value="2020" {{ Request::get('tahun') == 2020 ? 'selected' : '' }}>2020</option>
                                <option value="2021" {{ Request::get('tahun') == 2021 ? 'selected' : '' }}>2021</option>
                                <option value="2022" {{ Request::get('tahun') == 2022 ? 'selected' : '' }}>2022</option>
                                <option value="2023" {{ Request::get('tahun') == 2023 ? 'selected' : '' }}>2023</option>
                                <option value="2024" {{ Request::get('tahun') == 2024 ? 'selected' : '' }}>2024</option>
                                <option value="2025" {{ Request::get('tahun') == 2025 ? 'selected' : '' }}>2025</option>
                            </select>
                            <div class="btn-group ml-2 text-center">
                                <button type="submit" class="btn btn-info btn-sm">
                                    <span class="fa fa-plus"></span> Cari
                                </button>
                                <a href="{{ route('user.investor.keuangan') }}" class="btn btn-success btn-sm">
                                    <span class="fa fa-database"></span> Tampilkan semua
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
                <div class="box-body table-responsive" >
                    <table  class="table table-striped table-hover table-bordered table-align-middle text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Periode</th>
                                <th>Pemasukan</th>
                                <th>Pengeluaran</th>
                                <th>Keuntungan Bersih</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach ( ($cek == 'kosong' ? $keuntunganKotor : $keuntunganKotorBulan) as $key => $keuntunganKotor)
                            <tr>
                                <td>{{ $i++ }} .</td>
                                <td><b> {{ $convertBulan[$key] }} </b></td>
                                <td><b> {{ toRupiah($keuntunganKotor->nominal) }} </b></td>
                                <td><b>
                                    {{
                                        ($cek == 'kosong' ? (empty($pengeluaran[$key]) ? '-' : toRupiah($pengeluaran[$key]))
                                        :
                                        (empty($pengeluaran) ? '-' : toRupiah($pengeluaran)) )
                                    }}
                                </b></td>
                                <td><b>
                                    {{ ($cek == 'kosong' ? toRupiah($laba[$key]) : toRupiah($laba)) }}
                                 </b></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
@endsection
