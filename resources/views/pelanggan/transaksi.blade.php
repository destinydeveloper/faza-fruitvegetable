@extends('layouts.pelanggan')
@section('title', 'Transaksi - Faza')


@section('content')
  <div class="container" style="padding: 0 0.5rem;
  margin: 0 auto;
  max-width: 100% !important;
  width: 98%;margin-top: 30px;">   
    <div class="row" style="padding-top: 15px;">
      <div class="col s12">
        <ul class="tabs tabs-fixed-width z-depth-3">
          <li class="tab col s3"><a class="cyan-text active" href="#test0">COD</a></li>
          <li class="tab col s3"><a class="cyan-text" href="#test1">Belum Dikonfirmasi</a></li>
          <li class="tab col s3"><a class="cyan-text" href="#test2">Proses Mengirim</a></li>
          <li class="tab col s3"><a class="cyan-text" href="#test3">Telah Sampai</a></li>
          <li class="tab col s3"><a class="cyan-text" href="#test4">Dibatalkan</a></li>
        </ul>
      </div>
      <div id="test0" class="col s12 tab-transaksi" style="min-height: 400px;">
        @foreach ($cod as $item)
        <a onclick="window.location.href = '{{ route('transaksi.detail', ['kode' => $item->kode ]) }}';" href="javascript:void();" class="cyan-text">
          <div class="card horizontal">
              <div class="card-image">
                  <img src="{{ count($item->barangs[0]->barang->gambar) > 0 ? asset('assets/images/150x150/') . '/' . $item->barangs[0]->barang->gambar[0]->path : asset('assets/dist/img/no-image-150.png') }}">
              </div>
              <div class="card-stacked">
                <div class="card-content">
                    <p>
                      <b>{{ $item->kode }}</b><br>
                      <span class="black-text">{{ $item->created_at }}</span>
                    </p>
                </div>
                <div class="card-action">
                  <span>
                    <span class="black-text">Status : </span>
                    <span class="red-text">
                      @if($item->dikonfirmasi !== null)
                        Dikonfirmasi, Tunggu Komunikasi Selanjutnya
                      @else
                        Belum Di Konfirmasi
                      @endif
                    </span>
                  </span>
                </div>
              </div>
          </div>
        </a>
        @endforeach
      </div>
      <div id="test1" class="col s12 tab-transaksi" style="min-height: 400px;">
        @foreach ($belumkonfirmasi as $item)
        <a onclick="window.location.href = '{{ route('transaksi.detail', ['kode' => $item->kode ]) }}';" href="javascript:void();" class="cyan-text">
          <div class="card horizontal">
              <div class="card-image">
                  <img src="{{ count($item->barangs[0]->barang->gambar) > 0 ? asset('assets/images/150x150/') . '/' . $item->barangs[0]->barang->gambar[0]->path : asset('assets/dist/img/no-image-150.png') }}">
              </div>
              <div class="card-stacked">
                <div class="card-content">
                    <p>
                      <b>{{ $item->kode }}</b><br>
                      <span class="black-text">{{ $item->created_at }}</span>
                    </p>
                </div>
                <div class="card-action">
                  <span>
                    <span class="black-text">Status : </span>
                    <span class="red-text">
                      @if(count($item->bukti) == 0)
                        Belum Ada Bukti Pembayaran
                      @else
                        Menunggu DiKonfirmasi
                      @endif
                    </span>
                  </span>
                </div>
              </div>
          </div>
        </a>
        @endforeach
      </div>
      <div id="test2" class="col s12 tab-transaksi" style="min-height: 400px;">
          @foreach ($proseskirim as $item)
          <a onclick="window.location.href = '{{ route('transaksi.detail', ['kode' => $item->kode ]) }}';" href="javascript:void();" class="cyan-text">
            <div class="card horizontal">
                <div class="card-image">
                    <img src="{{ count($item->barangs[0]->barang->gambar) > 0 ? asset('assets/images/150x150/') . '/' . $item->barangs[0]->barang->gambar[0]->path : asset('assets/dist/img/no-image-150.png') }}">
                </div>
                <div class="card-stacked">
                  <div class="card-content">
                      <p>
                        <b>{{ $item->kode }}</b><br>
                        <span class="black-text">{{ $item->created_at }}</span>
                      </p>
                  </div>
                  <div class="card-action">
                    <span>
                      <span class="black-text">Status : </span>
                      <span class="red-text">
                        @if(count($item->track) == 0)
                          Proses Mengemas
                        @else
                          {{ $item->track[count($item->track)-1]->status }}
                        @endif
                      </span>
                    </span>
                  </div>
                </div>
            </div>
          </a>
          @endforeach
      </div>
      <div id="test3" class="col s12 tab-transaksi" style="min-height: 400px;">
          @foreach ($sampai as $item)
          <a onclick="window.location.href = '{{ route('transaksi.detail', ['kode' => $item->kode ]) }}';" href="javascript:void();" class="cyan-text">
            <div class="card horizontal">
                <div class="card-image">
                    <img src="{{ count($item->barangs[0]->barang->gambar) > 0 ? asset('assets/images/150x150/') . '/' . $item->barangs[0]->barang->gambar[0]->path : asset('assets/dist/img/no-image-150.png') }}">
                </div>
                <div class="card-stacked">
                  <div class="card-content">
                      <p>
                        <b>{{ $item->kode }}</b><br>
                        <span class="black-text">{{ $item->created_at }}</span>
                      </p>
                  </div>
                  <div class="card-action">
                    <span>
                      <span class="black-text">Status : </span>
                      <span class="red-text">Diterima pada [{{ $item->berhasil->created_at }}]</span>
                    </span>
                  </div>
                </div>
            </div>
          </a>
          @endforeach
      </div>
      <div id="test4" class="col s12 tab-transaksi" style="min-height: 400px;">
          @foreach ($batal as $item)
          <a onclick="window.location.href = '{{ route('transaksi.detail', ['kode' => $item->kode ]) }}';" href="javascript:void();" class="cyan-text">
            <div class="card horizontal">
                <div class="card-image">
                    <img src="{{ count($item->barangs[0]->barang->gambar) > 0 ? asset('assets/images/150x150/') . '/' . $item->barangs[0]->barang->gambar[0]->path : asset('assets/dist/img/no-image-150.png') }}">
                </div>
                <div class="card-stacked">
                  <div class="card-content">
                      <p>
                        <b>{{ $item->kode }}</b><br>
                        <span class="black-text">{{ $item->created_at }}</span>
                      </p>
                  </div>
                  <div class="card-action">
                    <span>
                      <span class="black-text">Status : </span>
                      <span class="red-text">
                        @if($item->konfirmasi)
                          @if(count($item->track) > 0 && $item->berhasil == null)
                            Kesalahan Pengiriman
                          @elseif($item->berhasil != null)
                            Tidak jadi diantar
                          @endif
                        @else
                          Tidak disetujui
                        @endif
                      </span>
                    </span>
                  </div>
                </div>
            </div>
          </a>
          @endforeach
      </div>
    </div>
  </div>
@endsection


@push('meta')
    <meta name="api" content="{{ route('transaksi') }}">    
@endpush


@push('js')
    <script>
    $(document).ready(function(){
      $('.tabs').tabs({});
    });
    </script>
@endpush

@push('css')
  <style>
  .tab-transaksi {
    /* min-height: 400px !important; */
  }
  </style>    
@endpush