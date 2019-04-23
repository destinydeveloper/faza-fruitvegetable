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
                    <div class="row" v-if="loading">
                        <div class="col s12 m12">
                            <div class="card horizontal">
                                <div class="card-content" style="text-align: center;width: 100%;">
                                    Loading...
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-if="!Object.keys(keranjang).length > 0 && loading == false">
                        <div class="card">
                            <div class="card-content" style="text-align: center;">
                                Tidak ada barang satupun.
                            </div>
                        </div>
                    </div>
                    <div v-if="error" class="row" style="margin-bottom: 5px;">
                        <div class="col s12 m12">
                            <div class="card horizontal yellow darken-4 white-text">
                                <div class="card-content" style="text-align: center !important;">
                                    <span>
                                        <i class="material-icons left">error</i>
                                        Terdapat produk yang tidak dapat diproses.
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-if="Object.keys(keranjang).length > 0">
                        <div class="col s12 m12" v-for="(item, i) in keranjang" :key="item.index">
                            <div class="card horizontal">
                                <div class="card-image">
                                    <img v-if="item.barang.gambar.length > 0" v-bind:src="'{{ asset('assets/images/150x150') }}/' + item.barang.gambar[0].path">
                                    <img v-else src="{{ asset('assets/dist/img/no-image-150.png') }}">
                                </div>
                                <div class="card-stacked">
                                <div class="card-content">
                                    <p>
                                        <b>@{{ item.barang.nama }}</b><br>
                                        <div v-if="item.error == 'itemHidden'">
                                            Produk Ini Sedang Tidak Ada, Mohon Hapus Produk Ini Dari Keranjang Dan Cari Produk Lainya.
                                            <br><button :disabled="loadingDel" v-on:click="app.delete(item.id)" title="Hapus" class="btn red waves-effect waves-light">x</button>
                                        </div>
                                        <div v-if="item.error == 'itemStockExceeded'">
                                            Produk Ini Memiliki Stok Terbatas dan Anda Melebihinya, Mohon Hapus Dari Keranjang Lalu Beli Produk Ini Lagi.
                                            <br><button :disabled="loadingDel" v-on:click="app.delete(item.id)" title="Hapus" class="btn red waves-effect waves-light">x</button>
                                        </div>
                                    </p>
                                </div>
                                <div class="card-action" v-if="item.error == ''">
                                    <div class="col l2 s8 center-align" style="padding:0px;margin-right: 10px;">
                                        <div class="input-field input-group" style="padding:0px;margin:0px;">
                                        <button class="btn waves-effect waves-light form-control sub" type="submit" id="sub" style="font-weight: bold;margin: 0px;padding: 0px;">-</button>
                                        <input v-bind:data-keranjang="i" v-bind:data-id="item.id" v-bind:data-max="item.barang_stok" @change="changeStok(e)" type="number" min="1" v-bind:value="item.stok" class="form-control center-align" style="font-weight: bold;margin: 0px;padding: 0px;height: auto;">
                                        <button class="btn waves-effect waves-light form-control add" type="submit" id="add" style="font-weight: bold;margin: 0px;padding: 0px;">+</button>
                                        </div>
                                    </div>
                                    <button :disabled="loadingDel" v-on:click="app.delete(item.id)" title="Hapus" class="btn red waves-effect waves-light">x</button>
                                    <span style="float: right;" class="harga">@{{ rupiah(item.barang.harga) }} | @{{ rupiah(parseInt(item.barang.harga) * item.stok) }}</span> 
                                </div>
                                </div>
                            </div>
                            {{-- <div class="card horizontal">
                                
                            </div> --}}
                        </div> 
                    </div>      
                </div>
                <div class="col l4 m4 s12">
                    <div class="card">
                        <div class="card-content">
                        <span class="card-title">Total Pembayaran</span>
                        <hr>
                        <div style="margin-top: 15px;">
                            <div style="text-align: center;" v-if="loading">
                                Loading...
                            </div>
                            <div v-else>
                                <span>Total Harga</span>
                                <span style="float: right;"><b><span>@{{ rupiah(total) }}</span></b></span>
                            </div>
                        </div>
                        </div>
                        <div class="card-action">
                            <a href="{{ route('keranjang.pengiriman') }}" :disabled="loading == true || error == true || !Object.keys(keranjang).length > 0" class="waves-effect waves-light btn">Beli</a>
                            <a href="{{ route('homepage') }}" class="waves-effect waves-light btn-flat">Lanjut Belanja</a>
                        </div>
                    </div>
                    <a v-on:click="destroy" :disabled="loadingDel" v-if="Object.keys(keranjang).length > 0" style="margin-bottom: 15px;width: 100%;" class="waves-effect waves-light btn-small red">
                        <i class="material-icons left">remove_circle</i>
                        Hapus Semua Keranjang
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--end container-->
@stop

@push('meta')
    <meta name="api" content="{{ route('keranjang') }}">    
@endpush

@push('js')
    <script>
    var app = new Vue({
        el: '#app',
        data: {
            keranjang: [],
            loading: true,
            loadingDel: false,
            error: false,
        },
        computed: {
            total(){
                let ttl = 0;
                // app.keranjang.forEach(function(item){
                //     ttl = ttl + (item.barang.harga * item.stok);
                // });
                for (let i = 0; i < Object.keys(app.keranjang).length; i++) {
                    ttl = ttl + (parseInt(app.keranjang[i].barang.harga) * parseInt(app.keranjang[i].stok));
                }
                return ttl;
            }
        },
        methods: {
            loadStart(){
                NProgress.start();
                NProgress.set(0.4);
            },
            loadDone(){
                setTimeout(function(){NProgress.done();}, loadTimeInterval);
            },
            rupiah(angka) {
                var rupiah = '';		
                var angkarev = angka.toString().split('').reverse().join('');
                for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
                return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
            },
            getKeranjang: function(){
                app.error = false;
                app.loadStart();
                app.loading = true;                
                axios.get('/').then(function(res){
                    app.loading = false;
                    if (res.data.status == 'success') {
                        console.log(res.data);
                        app.keranjang = res.data.result;

                        $.each(app.keranjang, function(i){
                            if (app.keranjang[i].error != "") app.error = true;
                        });
                    } else {
                    }
                    app.loadDone();
                        $(".add").prop('onclick', null).off('click');
                        $(".sub").prop('onclick', null).off('click');

                        setTimeout(function(){
                            $('.add').click(function () {
                                let max = $(this).prev().data("max");
                                let keranjang = $(this).prev().data("keranjang");
                                let id = $(this).prev().data("id");

                                if ($(this).prev().val() == max) {
                                    alertify.error("Maksimal stok tercapai");
                                    return false;
                                }
                                if ($(this).prev().val() < 99) {
                                    $(this).prev().val(+$(this).prev().val() + 1);
                                }

                                let stok = $(this).prev().val();
                                app.keranjang[keranjang].stok = stok;
                                app.updateStok(id, stok);
                            });
                            $('.sub').click(function () {
                                let keranjang = $(this).next().data("keranjang");
                                let id = $(this).next().data("id");
                                if ($(this).next().val() > 1) {
                                    if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() - 1);
                                } else {
                                    alertify.error("Minimal stok tercapai");
                                    return false;
                                }
                                let stok = $(this).next().val();
                                app.keranjang[keranjang].stok = stok;
                                app.updateStok(id, stok);
                            });
                        }, 200);
                });
            },
            delete(id){
                app.loadStart();
                app.loadingDel = true;  
                axios.post('/', {action: 'delete', 'id': id}).then(function(res){
                    if (res.data.status == 'success') {
                        app.getKeranjang();
                    } else {
                    }
                    app.loadingDel = false;
                    app.loadDone()
                }).catch(function(error){
                    error = error.response;
                    app.loadDone();
                    app.loading = false;
                    app.loadingDel = false;
                    if (error.status == 422){
                        let errors  = error.data.errors;
                        Object.keys(errors).map(function(item, index){
                            alertify.error(errors[item][0]);
                        });
                    } else { app.handleCatch(error); }
                });
            },
            destroy(){
                app.loadStart();
                app.loadingDel = true;  
                axios.post('/', {action: 'destroy'}).then(function(res){
                    if (res.data.status == 'success') {
                        app.getKeranjang();
                    } else {
                    }
                    app.loadingDel = false;
                    app.loadDone()
                }).catch(function(error){
                    error = error.response;
                    app.loadDone();
                    app.loading = false;
                    app.loadingDel = false;
                    if (error.status == 422){
                        let errors  = error.data.errors;
                        Object.keys(errors).map(function(item, index){
                            alertify.error(errors[item][0]);
                        });
                    } else { app.handleCatch(error); }
                });
            },
            updateStok(id, stok){
                app.loadStart();
                axios.post('/', {action: 'updateStok', 'id': id, 'stok': stok}).then(function(res){
                    if (res.data.status == 'success') {
                    } else {
                        alertify.error("Failed: update stock");
                    }
                    app.loadDone()
                }).catch(function(error){
                    error = error.response;
                    app.loadDone();
                    app.loading = false;
                    app.loadingDel = false;
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
                } else {
                    alertify.error('['+error.status+'] Error : '+'['+error.statusText+']');
                }
            },
        },
        mounted(){
            setTimeout(function(){app.getKeranjang();}, 1500);
        }
    });
    </script>
@endpush

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