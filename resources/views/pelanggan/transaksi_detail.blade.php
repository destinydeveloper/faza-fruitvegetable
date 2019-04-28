@extends('layouts.pelanggan')
@section('title')
    Transaksi - {{ $transaksi->kode }} - Faza
@stop


@section('content')
  <div class="container" style="padding: 0 0.5rem;
  margin: 0 auto;
  max-width: 100% !important;
  width: 98%;margin-top: 30px;">
    <div class="row">
        <div class="col s12">

            @if($errors->any())
            <h4>{{ $errors->first() }}</h4>
            @endif

            @if($transaksi->batal !== null)
            <div class="card horizontal yellow darken-4 white-text">
                <div class="card-content" style="text-align: center !important;">
                    <span>
                        <i class="material-icons left">error</i>
                        Transaksi Dibatalkan.
                    </span>
                </div>
            </div>
            @endif

            @if($transaksi->metode == "kirim barang")
                @if(count($transaksi->bukti) > 0 or $transaksi->batal != null)
                @else
                <div class="card">
                    <div class="card-action red-text">Pengingat!</div>
                    <div class="card-action">
                        <span>
                            Segera lakukan tranfer ke rekening yang sudah tercantum dibawah, 
                            lalu upload foto bukti pembayaran anda di menu dibawah. <br>
                            lakukan sebelum waktu habis, karena setelah waktu habis sebelum anda
                            mengirim foto bukti maka tranfer akan otomatis kami batalkan.
                        </span>
                        <h3 style="text-align: center;" id="timenya">
                            00:00:00
                        </h3>
                    </div>
                </div>
                @endif
            
                @if(count($transaksi->bukti) == 0)
                <div class="card">
                    <div class="card-action red-text">Pengingat Transfer!</div>
                    <div class="card-action" style="min-height: 100px;">
                        <div class="input-field col s12">
                            <select v-on:change="bankSelectShow = bankSelect;" v-model="bankSelect">
                                <option value="0" disabled selected>Pilih Bank</option>
                                <option v-for="(item, i) in bank" v-bind:value="item">@{{ item.bank }}</option>
                            </select>
                            <label>Pilih Bank Untuk Transfer</label>
                        </div>

                        <table class="responsive-table" v-if="bankSelectShow !== null">
                            <tr>
                                <th>Bank</th>
                                <td> : @{{ bankSelectShow.bank }}</td>
                            </tr>
                            <tr>
                                <th>Atas Nama</th>
                                <td> : @{{ bankSelectShow.nama }}</td>
                            </tr>
                            <tr>
                                <th>Nomor Rekening</th>
                                <td> : @{{ bankSelectShow.no }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                @endif
            @endif

            <div class="card">
            <div class="card-action">
                <button onclick="window.location.href = '{{ route('transaksi') }}';" class="waves-effect waves-light btn cyan">
                <i class="material-icons left">chevron_left</i>
                Kembali
                </button>
                <span style="margin-left: 15px;">
                    <b>{{ $transaksi->kode }}</b>
                </span>
            </div>
            <div class="card-action">
                <table>
                <tr>
                    <td><b>Kode</b></td>
                    <td> : {{ $transaksi->kode }}</td>
                </tr>
                <tr>
                    <td><b>Status</b></td>
                    <td> : 
                        @if($transaksi->batal !== null)
                            Dibatalkan - 
                            @if($transaksi->konfirmasi)
                                @if(count($transaksi->track) > 0 && $transaksi->berhasil == null)
                                    Kesalahan Pengiriman
                                @elseif($transaksi->berhasil != null)
                                    Tidak jadi diantar
                                @endif
                            @else
                                Tidak disetujui
                            @endif
                        @elseif($transaksi->berhasil !== null)
                            Telah Sampai
                        @else
                            @if($transaksi->konfirmasi && $transaksi->metode == "kirim barang")
                                Sedang Mengirim -
                                @if(count($transaksi->track) == 0)
                                    Proses Mengemas
                                @else
                                    {{ $transaksi->track[count($transaksi->track)-1]->status }}
                                @endif
                            @elseif($transaksi->konfirmasi && $transaksi->metode == "cod")
                                Dikonfirmasi, Tunggu Komunikasi Selanjutnya
                            @else
                                @if($transaksi->metode == "kirim barang")
                                    @if(count($transaksi->bukti) == 0)
                                        Belum Ada Bukti Pembayaran
                                    @else
                                        Menunggu DiKonfirmasi
                                    @endif
                                @elseif($transaksi->metode == "cod")
                                    Menunggu DiKonfirmasi
                                @else
                                @endif
                            @endif
                        @endif

                    </td>
                </tr>
                <tr>
                    <td><b>Metode</b></td>
                    <td>
                         : {{ $transaksi->metode }}
                         @if($transaksi->ekspedisi !== null)
                            - {{ $transaksi->ekspedisi->nama }} - 
                            {{ $transaksi->ekspedisi->layanan }}
                         @endif
                    </td>
                </tr>
                <tr>
                    <td><b>Foto Bukti pembayaran</b></td>
                    <td>
                        <div>
                            <img class="responsive-img" style="max-height: 250px;" src="{{ count($transaksi->bukti) == 0 ? asset('assets/dist/img/no-image-150.png') : asset('assets/images/original/' . $transaksi->bukti[0]->path) }}" alt="">
                        </div>
                        <button data-target="modal1" class="waves-effect waves-light btn modal-trigger">Upload Foto</button>
                    </td>
                </tr>
                </table>
            </div>
            </div>
        </div>

        @if( count($transaksi->track) )
        <div class="col s12">
            <div class="row">
                <div class="col l12" style="text-align: center;">
                    <div class="card" style="text-align: center;">
                        <div class="card-content" style="text-align: center;">
                            

                            <ol class="progtrckr" data-progtrckr-steps="5">
                                <li class="progtrckr-done">Proses Pengemasan</li>

                                    <li class="progtrckr-done">Proses Mengirim</li> 
                                    <li class="progtrckr-done">{{ substr($transaksi->track[count($transaksi->track)-1]->status, 0 ,24) }}...</li> 
                                    <li class="progtrckr-todo">...</li> 

                                <li class="{{ $transaksi->berhasil == null ? "progtrckr-todo" : "progtrckr-done" }}">Barang Sampai</li>
                            </ol>
                        </div>
                        <div class="card-action" style="text-align: left;">
                            <ul class="list2-material">
                                @foreach ($transaksi->track as $item)
                                <li>
                                    <i class="material-icons left">chevron_right</i>
                                    {{ $item->status }} <span class="grey-text">({{ $item->created_at }})</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="col s6">
            <div>
                <h4>
                    Barang
                </h4>
                <hr>
            </div>
            <div class="row">
                @foreach ($transaksi->barangs as $item)
                <div class="col l6">
                    <div class="card horizontal">
                            <div class="card-image">
                                <img src="{{ count($item->barang->gambar) == 0 ? asset('assets/dist/img/no-image-150.png')  : asset('assets/images/150x150/' . $item->barang->gambar[0]->path) }}" alt="">
                            </div>
                            <div class="card-stacked">
                                <div class="card-content">
                                    <p><b>{{ $item->barang->nama }}</b><br></p>
                                    <div>
                                        <div>
                                            <span>Stok</span>
                                            <span style="float: right;"><b><span>{{ $item->stok }}</span></b></span>
                                        </div>
                                        <div>
                                            <span>Harga</span>
                                            <span style="float: right;"><b><span>{{ $item->harga }}</span></b></span>
                                        </div>
                                        <div>
                                            <span>Berat</span>
                                            <span style="float: right;"><b><span>{{ $item->barang->berat }} kg</span></b></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                @endforeach
            </div>
      </div>

      <div class="col s6">

        <div class="card">
          <div class="card-action">
            Alamat Penerima
          </div>
          <div class="card-action">
              <span class="card-title">{{ $transaksi->alamat->penerima }}</span>
              <p>
                {{ $transaksi->alamat->no_telp }}<br> 
                <b>{{ $transaksi->alamat->alamat }}</b><br>
                {{ $transaksi->alamat->alamat_lengkap }}<br>
                {{ $transaksi->alamat->kodepos }}<br>
              </p>
          </div>
        </div>

        </div>
      </div>

    </div>

    <!-- Modal Structure -->
    <div id="modal1" class="modal">
        <div class="modal-content">
            <h4>Upload Foto Bukti Pembayaran</h4>
            <p>
                Foto bukti pembayaran anda setelah anda upload akan kami check
                apakah sesuai, setelah sesuai kami akan memproses transaksi anda.
            </p>
            <form method="POST" id="form-upload-bukti" enctype="multipart/form-data">
                @csrf                
                <input type="hidden" name="action" value="uploadbukti">
                <div class="file-field input-field">
                    <div class="btn">
                        <span>Foto</span>
                        <input type="file" name="image">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" placeholder="upload foto bukti">
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
                <a href="javascript:void()" onclick="$('form#form-upload-bukti').submit();" class="modal-close waves-effect waves-green btn">Upload</a>
                <a href="javascript:void()" class="modal-close waves-effect waves-green btn white-text red">Batal</a>
        </div>
    </div>
@stop


@push('js')
    <script>
    $(document).ready(function(){
        $('.modal').modal();
        $('select').formSelect();
        hitungMundur();
    });

    function hitungMundur() {
        let html = $('#timenya');

        let minute = {!! $waktu[2] !!};
        let hour = {!! $waktu[1] !!};
        let second = {!! $waktu[3] !!};

        if (hour < 10) hour = "0" + hour;
        if (second < 10) second = "0" + second;
        if (minute < 10) minute = "0" + minute;
        var countdown = setInterval(function(){
            if (second > 0) { 
                second = second - 1; 
            } else { 
                second = 59;
                if (minute > 0) {
                    minute = minute - 1;
                } else {
                    minute = 59;
                    if (hour > 0) {
                        hour = hour - 1;
                    } else {
                        hour = 0;
                    }
                    if (hour < 10) hour = "0" + hour;
                }
                if (minute < 10) minute = "0" + minute;
            }

            if (second < 10) second = "0" + second;

            html.html( hour + ":" + minute + ":" + second );

            if (second == 0 && minute == 0 && hour == 0) {
                window.location.reload();
            }
        }, 1000);
    }

    var app = new Vue({
        el: '#app',
        data: {
            bankSelect: null,
            bank: {!! json_encode($bank) !!},
            bankSelectShow: null,
        }
    });
    </script>
@endpush


@push('css')
    <style>
    ol.progtrckr {
    margin: 0;
    padding: 0;
    list-style-type none;
}

ol.progtrckr li {
    display: inline-block;
    text-align: center;
    line-height: 3.5em;
}

ol.progtrckr[data-progtrckr-steps="2"] li { width: 49%; }
ol.progtrckr[data-progtrckr-steps="3"] li { width: 33%; }
ol.progtrckr[data-progtrckr-steps="4"] li { width: 24%; }
ol.progtrckr[data-progtrckr-steps="5"] li { width: 19%; }
ol.progtrckr[data-progtrckr-steps="6"] li { width: 16%; }
ol.progtrckr[data-progtrckr-steps="7"] li { width: 14%; }
ol.progtrckr[data-progtrckr-steps="8"] li { width: 12%; }
ol.progtrckr[data-progtrckr-steps="9"] li { width: 11%; }

ol.progtrckr li.progtrckr-done {
    color: black;
    border-bottom: 4px solid yellowgreen;
}
ol.progtrckr li.progtrckr-todo {
    color: silver; 
    border-bottom: 4px solid silver;
}

ol.progtrckr li:after {
    content: "\00a0\00a0";
}
ol.progtrckr li:before {
    position: relative;
    bottom: -2.5em;
    float: left;
    left: 50%;
    line-height: 1em;
}
ol.progtrckr li.progtrckr-done:before {
    content: "\2713";
    color: white;
    background-color: yellowgreen;
    height: 2.2em;
    width: 2.2em;
    line-height: 2.2em;
    border: none;
    border-radius: 2.2em;
}
ol.progtrckr li.progtrckr-todo:before {
    content: "\039F";
    color: silver;
    background-color: white;
    font-size: 2.2em;
    bottom: -1.2em;
}
/*********************************/
.list1-material,
.list2-material {
  padding: 0;
}
.list1-material li,
.list2-material li {
  padding: 1.5em 1em;
  overflow: hidden;
  /* background-color: #FBF8FA; */
  font-weight: bold;
  color: gray;
}
.list1-material li:hover, .list1-material li:active, .list1-material li:focus,
.list2-material li:hover,
.list2-material li:active,
.list2-material li:focus {
  position: relative;
}
.list1-material li:hover::after, .list1-material li:active::after, .list1-material li:focus::after,
.list2-material li:hover::after,
.list2-material li:active::after,
.list2-material li:focus::after {
  position: absolute;
  top: 50%;
  left: 50%;
  content: " ";
  display: block;
  width: 10px;
  height: 10px;
  border-radius: 100%;
  -webkit-animation: anima-list 1s infinite;
          animation: anima-list 1s infinite;
}

.list1-material li {
  margin: 1em 0;
  border-radius: 0.25em;
  box-shadow: 0 5px 10px -7px #444, inset 0 0 5px #EEE;
  transition: box-shadow 0.75s;
}
.list1-material li:hover, .list1-material li:active, .list1-material li:focus {
  box-shadow: 0 12px 10px -7px #CCC, inset 0 0 5px #EEE;
}

.list2-material li {
  margin: 0;
  border-bottom: 1px solid rgba(211, 211, 211, 0.5);
}

@-webkit-keyframes anima-list {
  0% {
    background: none;
    box-shadow: none;
  }
  50% {
    background: rgba(211, 211, 211, 0.3);
    box-shadow: 0 0 0 80px rgba(211, 211, 211, 0.25), 0 0 50px 125px rgba(211, 211, 211, 0.15);
  }
  100% {
    background: none;
    box-shadow: none;
  }
}

@keyframes anima-list {
  0% {
    background: none;
    box-shadow: none;
  }
  50% {
    background: rgba(211, 211, 211, 0.3);
    box-shadow: 0 0 0 80px rgba(211, 211, 211, 0.25), 0 0 50px 125px rgba(211, 211, 211, 0.15);
  }
  100% {
    background: none;
    box-shadow: none;
  }
}
/****************************************************/

</style>    
@endpush