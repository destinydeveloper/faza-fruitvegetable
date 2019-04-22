@extends('layouts.pelanggan')
@section('title', 'Faza')

@section('content')
    <!--start container-->
    <div class="container" style="padding: 0 0.5rem;
    margin: 0 auto;
    max-width: 100% !important;
    width: 98%;">
        <div class="section" style="background: white;margin-bottom: 15px;">
            <!-- statr products list -->
            <div class="row">
                <div class="col l3 s12 m12 colmob" style="overflow:hidden; text-align: center;">
                    <div class="row">
                    <div class="col l12" style="text-align: center; content-align: center;">
                        <a href="{{ count($barang->gambar) == 0 ? asset('assets/dist/img/no-image.png') : asset('assets/images/original/' . $barang->gambar[0]->path) }}" class="MagicZoom" id="jeans" data-options="zoomMode: magnifier; zoomOn: click; zoomPosition: left; expand: off; expandZoomMode: magnifier;"><img src="{{ count($barang->gambar) == 0 ? asset('assets/dist/img/no-image.png') : asset('assets/images/original/' . $barang->gambar[0]->path) }}" width="100%" height="300px" style="max-height: 300px !important;min-height: 300px !important;"></a>
                    </div>
                    @if(count($barang->gambar) > 0)
                    <div class="col l12" style="margin-top:10px;">
                        @foreach ($barang->gambar as $gambar)
                        <a href="{{ asset('assets/images/original/' . $gambar->path ) }}" data-zoom-id="jeans" href="javascript:void();" data-image="{{ asset('assets/images/original/' . $gambar->path ) }}"><img src="{{ asset('assets/images/original/' . $gambar->path ) }}" width="64px" height="auto" style="border: 1px solid black;"></a>
                        @endforeach
                    </div>
                    @endif
                    </div>
                </div>
                <div class="col l9 s12 m12  colmob">
                    <ul class="collection with-header" style="border:none;">
                        <li class="collection-header" style="margin: 0px 30px;padding: 10px;"><h4 style="margin:0px;"><b>{{ $barang->nama }}</b></h4></li>
                        <li class="collection-item">
                            <div class="row">
                                {{-- <dib class="col l12" style="height: 128px;overflow: hidden;">
                                    <p>Deskripsi Singkat maxsimal kata 100 kata... Micin dibuat dari sari kedele, yang mampus menetralkan pikiran dari ancaman gempa banjir longsor. Sering kali di singkat sebagai makanan kebutuhan manusia dan hewan</p>
                                </dib> --}}
                                <div class="col l12" style="margin-top:10px;">
                                    <table class="highlight striped">
                                        <tbody>
                                            <tr>
                                                <td>Stok</td>
                                                <td>{{ $barang->stok }} {{ $barang->satuan_stok }}</td>
                                            </tr>
                                            <tr>
                                                <td>Harga</td>
                                                <td>Rp. {{ number_format($barang->harga,2,',','.') }}</td>
                                            </tr>
                                            <tr>
                                                <td>Berat</td>
                                                <td>{{ $barang->berat }} kg</td>
                                            </tr>
                                            <tr>
                                                <td>Jenis</td>
                                                <td>{{ $barang->jenis }}</td>
                                            </tr>
                                            <tr>
                                                <td>Pengiriman</td>
                                                <td>
                                                    <ul>
                                                        <li><i class="material-icons" style="font-size: 14px;">chevron_right</i> COD (Khusus Malang)</li>
                                                        <li>
                                                            <ul>
                                                                @foreach (Ekspedisi()->get() as $item)
                                                                    <li><i class="material-icons" style="font-size: 14px;">chevron_right</i> {{ $item->name }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="col l12" style="margin-top:10px;">
                                    <div class="col l2 s8 center-align" style="padding:0px;margin-right:10px;">
                                        <div class="input-field input-group" style="padding:0px;margin:0px;">
                                            <button class="btn waves-effect waves-light form-control sub" type="submit" id="sub" style="font-weight: bold;margin: 0px;padding: 0px;">-</button>
                                            <input id="stok" type="number" min="1" max="5" value="1" class="form-control center-align" id="1"  style="font-weight: bold;margin: 0px;padding: 0px;height: auto;">
                                            <button class="btn waves-effect waves-light form-control add" type="submit" id="add" style="font-weight: bold;margin: 0px;padding: 0px;">+</button>
                                        </div>
                                    </div>
                                    <a v-on:click="tambah" class="waves-effect waves-light btn"><i class="material-icons">add_shopping_cart</i></a>
                                </div>
                            </div>
                        </li>
                    </ul>               
              </div>
              <div class="col l12 m12 s12">
                    <div class="col l6 m6 s6 ">
                        <a href="{{ url()->previous() }}" class="waves-effect waves-light btn left acfix" style="width: 50%;">Kembali</a>
                    </div>
                    <div class="col l6 m6 s6 ">
                        <button v-on:click="beli" class="waves-effect waves-light btn right acfix" style="width: 50%;">Beli</button>
                        <form id="beliForm" method="POST" action="{{ route('keranjang') }}">
                            @csrf
                            <input type="hidden" name="action" value="beli">
                            <input type="hidden" name="id" value="{{ $barang->id }}">
                            <input type="hidden" name="stok" v-model="stok">
                        </form>
                    </div>
              </div>
            </div>
            <!--/ end items list -->
        </div>
    </div>
@stop

@push('meta')
    <meta name="api" content="{{ route('keranjang') }}">    
@endpush

@push('js')
    <script src="{{ asset('assets/dist/js/magiczoomplus.js') }}" type="text/javascript"></script>
    <script>
    $(document).ready(function() {
        $('.add').click(function () {
            if ($(this).prev().val() < 99) {
            $(this).prev().val(+$(this).prev().val() + 1);
		}
        });
        $('.sub').click(function () {
            if ($(this).next().val() > 1) {
            if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() - 1);
            }
        });
	}); 

    var app = new Vue({
        el: '#app',
        data: { stok: 1 },
        methods: {
            loadStart(){
                NProgress.start();
                NProgress.set(0.4);
            },
            loadDone(){
                setTimeout(function(){NProgress.done();}, loadTimeInterval);
            },
            beli: function(){
                @auth
                $('#beliForm input[name="stok"]').val( $('#stok').val() );
                $('#beliForm').submit();
                @else
                let login = alertify.notify("Anda perlu login terlebih dahulu, Klik untuk login", "error", 3);
                login.callback = function(isClicked) { if(isClicked) window.location.href = "{{ route('login') }}"; };
                @endauth
            },
            tambah: function(){
                app.loadStart();
                axios.post('', {action: 'tambah', 'id': {{ $barang->id }}, 'stok': $('#stok').val()}).then(function(res){
                    if (res.data.status == 'success') {
                        var notification = alertify.notify('Menambahkan barang ke keranjang, klik untuk lihat', 'success', 5);
                        notification.callback = function (isClicked) {  if(isClicked) window.location.href = "{{ route('keranjang') }}";  };
                    } else {
                        alertify.error("Failed: Cannt added shopping cart");
                    }
                    app.loadDone();
                }).catch(function(error){
                    error = error.response;
                    app.loadDone();
                    if (error.status == 422){
                        let errors  = error.data.errors;
                        Object.keys(errors).map(function(item, index){
                            alertify.error(errors[item][0]);
                        });
                    } else { app.handleCatch(error); }
                });
            },
            handleCatch(error) {
                app.loadDone();
                console.log(error);
                if (error.status == 500) {
                    alertify.error('Server Error, Try again later');
                } else if (error.status == 422) {
                    alertify.error('Form invalid, Check input form');
                } else if (error.status== 401) {
                    let login = alertify.notify("Anda perlu login terlebih dahulu, Klik untuk login", "error", 3);
                    login.callback = function(isClicked) { if(isClicked) window.location.href = "{{ route('login') }}"; };
                } else {
                    alertify.error('['+error.status+'] Error : '+'['+error.statusText+']');
                }
            },
        },
        mounted(){
        }
    });
    </script>
@endpush

@push('css')
    <link href="{{ asset('assets/dist/css/magiczoomplus.css') }}" rel="stylesheet" type="text/css" media="screen"/>
    <style>
     .mz-expand>span,
    figure>span,
    figure.mz-figure>span{
        display: none !important;
    }
    figure>span{
        display: none !important;
    }
    figure>img{
        height: 300px !important;
        min-height: 300px !important;
        text-align: center !important;
        width: 300px !important;
        min-width: 300px !important;
        max-width: 300px !important;
    }
    .form-control{
        position: relative;
    -webkit-box-flex: 1;
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    width: 1% !important;
    margin-bottom: 0;
    }
    .input-group{
        position: relative;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    -webkit-box-align: stretch;
    -ms-flex-align: stretch;
    align-items: stretch;
    width: 100%;
    }
    </style>
@endpush