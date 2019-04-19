@extends('layouts.pelanggan')
@section('title', 'Faza')

@section('content')
    <!-- carausel -->
    {{-- <div class="carousel carousel-slider" data-indicators="true" style="margin-top:10px;">
        <a class="carousel-item" href="#one!"><img src="{{ asset('assets/dist/img/carousel/bg.jpg') }}" ></a>
        <a class="carousel-item" href="#two!"><img src="{{ asset('assets/dist/img/carousel/2.jpg') }}"></a>
        <a class="carousel-item" href="#three!"><img src="{{ asset('assets/dist/img/carousel/3.jpg') }}"></a>
        <a class="carousel-item" href="#four!"><img src="{{ asset('assets/dist/img/carousel/bg1.jpg') }}"></a>
    </div>             --}}
    <!-- end carusel -->
    
    <!--start container-->
    <div class="container" style="padding: 0 0.5rem;
    margin: 0 auto;
    max-width: 100% !important;
    width: 98%;">
        <div class="section">
            <!-- statr products list -->
            <div class="row">
                <div class="col l12 s12 colmob">
                    @foreach ($barangs as $barang)
                    <div class="col l3 s6 m4 colmob1">
                        <div id="products" class="row">
                            <div class="product" style="padding:10px;">
                                <div class="card">
                                    <div class="card-image waves-effect waves-block waves-light">
                                        <a href="{{ route('barang.detail', [$barang->id]) }}">
                                            <img src="{{ count($barang->gambar) == 0 ? asset('assets/dist/img/no-image-800.png') : asset('assets/images/800x600/' . $barang->gambar[0]->path) }}" alt="product-img" class="gambarmob">
                                        </a>
                                    </div>
                                    <div class="card-content" style="padding: 16px;">
                                        <div class="row" style="margin-bottom:0px;">
                                            <div class="col s12 judtex" style="padding:10px;">
                                                <p class="card-title grey-text text-darken-4" style="font-weight: bold;height: 60px;overflow: hidden;">
                                                    <a href="{{ route('barang.detail', [$barang->id]) }}" class="grey-text text-darken-4">{{ $barang->nama }}</a>
                                                </p>
                                            </div>
                                            <div class="col s8 l6 m6 harpa">
                                                <span>Rp {{ number_format($barang->harga,2,',','.') }}</span> 
                                            </div>
                                            <div class="col s4 l6 m6 no-padding right right-align">
                                                <span>Stock {{ $barang->stok == 0 ? "Habis" : "Ready" }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>      
                    @endforeach            
                </div>
                <div class="col l6 s12 m6">    
                </div>
                {{-- <div class="col l6 s12 m6">
                    <ul class="pagination right-align">
                        <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
                        <li class="active"><a href="#!">1</a></li>
                        <li class="waves-effect"><a href="#!">2</a></li>
                        <li class="waves-effect"><a href="#!">3</a></li>
                        <li class="waves-effect"><a href="#!">4</a></li>
                        <li class="waves-effect"><a href="#!">5</a></li>
                        <li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
                    </ul>
                </div> --}}
            </div>
            <!--/ end items list -->
        </div>
    </div>
    <!--end container-->
@stop
