@extends('layouts.user')
@section('title', 'User \ Investor')
@section('page-header', 'Dashboard')

@section('content')
    <div class="row m-3">
        <div class="col-md-4 col-xs-12">
            <div class="card text-left bg-primary text-white">
              <img class="card-img-top" src="holder.js/100px180/" alt="">
              <div class="card-body">
                <h4 class="card-title">Jumlah Sayur dan Buah</h4>
                <p class="card-text">
                    <h1 class="d-inline">{{ $jml_buah_sayur }} buah</h1>
                </p>
              </div>
            </div>
        </div>
        <div class="col-md-4 col-xs-12">
            <div class="card text-left bg-danger text-white">
                <img class="card-img-top" src="holder.js/100px180/" alt="">
                <div class="card-body">
                    <h4 class="card-title">Keuntungan bulan ({{date('F')}})</h4>
                    <p class="card-text">
                        <h1 class="d-inline">{{ toRupiah($keuntungan_bulan->pluck('nominal')[0]) }}</h1>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xs-12">
            <div class="card text-left bg-info text-white">
                <img class="card-img-top" src="holder.js/100px180/" alt="">
                <div class="card-body">
                    <h4 class="card-title">Jumlah investasi terakhir</h4>
                    <p class="card-text">
                        @if ($total_investasi == null)
                            <h1 class="d-inline">Data belum diterima</h1>
                        @else
                            <h1 class="d-inline">{{ toRupiah($total_investasi->nominal) }}</h1>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row m-3 text-center"  style="background: white">
        <div class="col-md-12 col-xs-12">
            {!! $chart->container() !!}
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
    {!! $chart->script() !!}
@endpush
