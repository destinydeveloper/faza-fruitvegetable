@extends('layouts.pelanggan')
@section('title', 'Kirim Barang - Faza')

@section('content')
    <!--start container-->
    <div class="container" style="padding: 0 0.5rem;
    margin: 0 auto;
    max-width: 100% !important;
    width: 98%;">
        <div class="section">
            <div class="row">
                <div class="col l8">
                    <div class="card">
                        <div class="card-action">
                            <span class="card-title">Alamat Pengiriman</span>
                        </div>
                        <div class="card-action">
                            <span class="red-text" v-if="alamat == null">Pilih Alamat Terlebih Dahulu</span>
                            <div v-else>
                                <div class="card-title">@{{ alamats[alamat].penerima }}</div>
                                <p>
                                    @{{ alamats[alamat].no_telp }}<br>
                                    <b>@{{ alamats[alamat].alamat }}</b><br>
                                    @{{ alamats[alamat].alamat_lengkap }}<br>
                                    @{{ alamats[alamat].kodepos }}<br>
                                </p>
                            </div>
                        </div>
                        <div class="card-action">
                            <a class="waves-effect waves-light btn cyan modal-trigger" onclick="$('#modal1').modal('open');">Pilih Alamat</a>
                            <a @click="buatAlamat" class="waves-effect waves-light btn green darken-2 right">Buat Alamat Baru</a>
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-action">
                            <span class="card-title">Metode Pembelian</span>
                        </div>
                        <div class="card-action">
                            <span class="red-text" v-if="alamat == null">Pilih Alamat Terlebih Dahulu</span>
                            <div v-show="alamat != null">
                                <div class="input-field">
                                    <select @change="cekOngkir" v-model="metode">
                                        <option value="null" disabled selected>Pilih</option>
                                        <option value="cod">COD (Daerah Malang)</option>
                                        <option v-for="(item, i) in ekspedisi" :key="item.$index" v-bind:value="i">@{{ item.name }}</option>
                                    </select>
                                    <label>Pilih Metode</label>
                                </div>
                            </div>
                            <div v-if="layananEkspedisi != null">
                                <label>Pilih Layanan</label>
                                <div class="input-field">
                                    <select @change="pilihLayanan" v-model="layanan" class="browser-default">
                                        <option v-for="(item, i) in layananEkspedisi" :key="item.$index" v-bind:value="i">@{{ item.service }} [@{{ item.description }}]</option>
                                    </select>
                                </div>
                            </div>
                            <div v-if="metode != 'cod' && metode != null && layananEkspedisi != null">
                                <hr>
                                <div style="text-align: center;" v-if="loadingMetode">
                                    Loading...
                                </div>
                                <table class="highlight striped" v-if="layanan != null">
                                    <tbody>
                                        <tr>
                                            <td>Kurir</td>
                                            <td> : @{{ ekspedisi[metode].name }} [@{{ layananEkspedisi[layanan].service }}]</td>
                                        </tr>
                                        <tr>
                                            <td>Kirim Ke</td>
                                            <td> : @{{ alamats[alamat].alamat }} </td>
                                        </tr>
                                        <tr>
                                            <td>Pekiraan Sampai</td>
                                            <td> : @{{ layananEkspedisi[layanan].cost[0].etd }} Hari </td>
                                        </tr>
                                        <tr>
                                            <td>Ongkos Kirim</td>
                                            <td> : @{{ rupiah(layananEkspedisi[layanan].cost[0].value) }} </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    
                    <div>
                        <h4>
                            Barang
                            <small> (Keranjang)</small>
                        </h4>
                        <hr>
                    </div>
                    <div class="row">
                        <div class="col l6" v-for="(item, i) in keranjang" :key="item.$index">
                            <div class="card horizontal">
                                    <div class="card-image">
                                        <img v-if="item.barang.gambar.length > 0" v-bind:src="'{{ asset('assets/images/150x150') }}/' + item.barang.gambar[0].path">
                                        <img v-else src="{{ asset('assets/dist/img/no-image-150.png') }}">
                                    </div>
                                    <div class="card-stacked">
                                        <div class="card-content">
                                            <p><b>@{{ item.barang.nama }}</b><br></p>
                                            <div>
                                                <div>
                                                    <span>Stok</span>
                                                    <span style="float: right;"><b><span>@{{ item.stok }}</span></b></span>
                                                </div>
                                                <div>
                                                    <span>Harga</span>
                                                    <span style="float: right;"><b><span>@{{ rupiah(item.barang.harga) }}</span></b></span>
                                                </div>
                                                <div>
                                                    <span>Berat</span>
                                                    <span style="float: right;"><b><span>@{{ item.barang.berat }} kg</span></b></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="col l4">
                    <div class="card" id="card-bayar">
                        <div class="card-action">
                            <span class="card-title">Total Pembayaran  (@{{ Object.keys(keranjang).length }} barang)</span>
                        </div>
                        <div class="card-action">
                            <div>
                                <div>
                                    <span>Total Harga</span>
                                    <span style="float: right;"><b><span>@{{ rupiah(totalharga) }}</span></b></span>
                                </div>
                                <div v-if="ongkir != 0">
                                    <span>Ongkos Kirim</span>
                                    <span style="float: right;"><b><span>@{{ rupiah(ongkir) }}</span></b></span>
                                </div>
                                <div>
                                    <span>Total Berat</span>
                                    <span style="float: right;"><b><span>@{{ totalberat }} kg</span></b></span>
                                </div>
                            </div>
                        </div>
                        <div class="card-action">
                            <a href="{{ route('homepage') }}" class="waves-effect waves-light btn-flat">Batal</a>
                            <a @click="alert('ashiap');" :disabled="alamat == null || metode == null || layanan == null" href="javascript:void();" class="waves-effect waves-light btn right">Proses Transaksi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Structure -->
    <div id="modal1" class="modal bottom-sheet">
        <div class="modal-content">
        <h4>Pilih Alamat</h4>
        <div>
            <div class="collection">
                <a href="javscript:void;" class="collection-item avatar" style="padding-left: 10px;" v-for="(item, i) in alamats" :key="item.$index" v-on:click.prevent="pilihAlamat(i, item.id)">
                    <span class="title">@{{ item.penerima }}</span>
                    <p><b>@{{ item.alamat }}</b><br>
                        @{{ item.alamat_lengkap }}
                    </p>
                </a>
            </div>
        </div>
        </div>
        <div class="modal-footer">
        <a href="javascript:void();" class="modal-close waves-effect waves-green btn-flat">Batal</a>
        </div>
    </div>
@stop



@push('meta')
    <meta name="api" content="{{ route('keranjang.pengiriman') }}">    
@endpush

@push('js')
    <script>
    $(document).ready(function(){
        initAll();
        cardBayarInit();
    });
    $( window ).resize(function() {
        cardBayarInit();
    });
    function initAll(){
        $('#modal1').modal();
        $('select').formSelect();
    }
    function cardBayarInit(){
        let bayar = $('#card-bayar');
        bayar.css({'position': 'relative'});
        let lebar = bayar.width();
        bayar.css({'position': 'fixed', 'width': lebar+'px'});
    }
    var app = new Vue({
        el: '#app',
        data: {
            keranjang: {!! json_encode($keranjang) !!},
            alamats: {!! json_encode($alamat) !!},
            ekspedisi: {!! json_encode($ekspedisi) !!},
            alamat: null,
            alamat_id: null,
            loadingMetode: true,
            ongkir: 0,
            metode: null,
            layananEkspedisi: null,
            layanan: null,
        },
        computed: {
            totalberat(){
                let ttl = 0;
                let keranjang = this.keranjang;
                for (let i = 0; i < Object.keys(keranjang).length; i++) {
                    ttl = ttl + ( (parseInt(keranjang[i].barang.berat)) * (parseInt(keranjang[i].stok)) );
                }
                return ttl;
            },
            totalharga(){
                let ttl = 0;
                let keranjang = this.keranjang;
                for (let i = 0; i < Object.keys(keranjang).length; i++) {
                    ttl = ttl + (parseInt(keranjang[i].barang.harga) * parseInt(keranjang[i].stok));
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
            buatAlamat(){
                window.location.href = "{{ route('user.alamat') }}";
            },
            pilihAlamat(index, id){
                app.ongkir = 0;
                app.metode = "null";
                app.layananEkspedisi = null;
                app.layanan = null;
                app.alamat = index;
                app.alamat_id = id;
                $('#modal1').modal('close');
            },
            cekOngkir(){
                app.loadStart();
                app.loadingMetode = true;                
                let params = {
                    action: 'cekongkir',
                    ekspedisi: app.metode,
                    berat: app.totalberat,
                    alamat: app.alamats[app.alamat].alamat
                };
                axios.post('/', params).then(function(res){
                    app.loadingMetode = false;
                    app.loadDone();
                    if (res.data.status == 'success') {
                        app.layananEkspedisi = res.data.result.ongkir.costs;
                    }
                    
                    console.log(res.data);
                }).catch(function(error){
                    error = error.response;
                    app.loadDone();
                    app.loadingMetode = false;
                    if (error.status == 422){
                        let errors  = error.data.errors;
                        Object.keys(errors).map(function(item, index){
                            alertify.error(errors[item][0]);
                        });
                    } else { app.handleCatch(error); }
                });
            },
            pilihLayanan(){
                app.ongkir = app.layananEkspedisi[app.layanan].cost[0].value;
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
            console.log(this.keranjang);
            console.log(this.alamats);
            console.log(this.ekspedisi);            
        }
    });
    </script>
@endpush