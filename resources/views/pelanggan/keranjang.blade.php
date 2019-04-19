@extends('layouts.pelanggan')
@section('title', 'Keranjang - Faza')

@section('content')
    <!--start container-->
    <div class="container" style="padding: 0 0.5rem;
    margin: 0 auto;
    max-width: 100% !important;
    width: 98%;">
        <div class="section">
            <!-- statr products list -->
            <div class="row">
                <div class="col l8">
                    <div class="row">
                    @foreach ($keranjang as $item)
                    <div class="col s12 m12">
                        <div class="card horizontal">
                            <div class="card-image">
                            <img src="{{ count($item->barang->gambar) == 0 ? asset('assets/dist/img/no-image.png') : asset('assets/images/150x150/' . $item->barang->gambar[0]->path) }}">
                            </div>
                            <div class="card-stacked">
                            <div class="card-content">
                                <p>
                                    <b>{{ $item->barang->nama }}</b>
                                </p>
                            </div>
                            <div class="card-action">
                                <div class="col l2 s8 center-align" style="padding:0px;margin-right: 10px;">
                                    <div class="input-field input-group" style="padding:0px;margin:0px;">
                                    <button class="btn waves-effect waves-light form-control sub" type="submit" id="sub" style="font-weight: bold;margin: 0px;padding: 0px;">-</button>
                                    <input type="number" min=1 value="{{ $item->stok }}" class="form-control center-align" id="1"  style="font-weight: bold;margin: 0px;padding: 0px;height: auto;">
                                    <button class="btn waves-effect waves-light form-control add" type="submit" id="add" style="font-weight: bold;margin: 0px;padding: 0px;">+</button>
                                    </div>
                                </div>
                                <button title="Hapus" class="btn red waves-effect waves-light">x</button>
                                <span style="float: right;" class="harga">RP. 10.0000.000</span> 
                            </div>
                            </div>
                        </div>
                    </div>    
                    @endforeach       
                    </div>                 
                </div>
                <div class="col l4 m4 s12">
                    <div class="card">
                        <div class="card-content">
                        <span class="card-title">Total Pembayaran</span>
                        <hr>
                        <div style="margin-top: 15px;">
                            <span>Total Harga</span>
                            <span style="float: right;"><b>Rp 10000</b></span>
                        </div>
                        </div>
                        <div class="card-action">
                            <a class="waves-effect waves-light btn">Beli</a>
                            <a class="waves-effect waves-light btn-flat">Lanjut Belanja</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end container-->
@stop


@push('css')
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

@push('js')
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
    </script>
@endpush