<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'PelangganController@index')->name('homepage');
Route::get('/barang/{barang_id}', 'PelangganController@barang_detail')->name('barang.detail');
Route::get('/search/{q}', 'PelangganController@search');
Route::get('/sayur', 'PelangganController@sayur')->name('barang.sayur');
Route::get('/buah', 'PelangganController@buah')->name('barang.buah');

Route::group([
    'middleware' => 'auth'
], function () {
    Route::get('/keranjang', 'PelangganKeranjangController@index')->name('keranjang');
    Route::post('/keranjang', 'PelangganKeranjangController@action')->name('keranjang.action');
    Route::get('/keranjang/pengiriman', 'PelangganKeranjangPengirimanController@index')->name('keranjang.pengiriman');
    Route::post('/keranjang/pengiriman', 'PelangganKeranjangPengirimanController@action')->name('keranjang.pengiriman.action');
    Route::get('/transaksi', 'PelangganTransaksiController@index')->name('transaksi');
    Route::get('/transaksi/{kode}', 'PelangganTransaksiDetailController@index')->name('transaksi.detail');
    Route::post('/transaksi/{kode}', 'PelangganTransaksiDetailController@action')->name('transaksi.detail.action');
});


Auth::routes();


Route::group([
    'prefix' => 'user',
    'as' => 'user.',
    'middleware' => 'auth'
], function () {
    Route::get('/', 'UserHomeController@index')->name('home');

    Route::group(['middleware' => ['role:admin|pengepak|supervisor|kurir']], function(){
        Route::get('/biaya-operasional', 'BiayaOperasionalController@index')->name('biaya_operasional');
        Route::post('/biaya-operasional', 'BiayaOperasionalController@action')->name('biaya_operasional.action');
    });

    Route::group(['prefix' => 'manager'], function(){
        Route::group(['middleware' => ['role:admin']], function(){

            // Manager User
            Route::get('/user', 'ManagerUserController@index')->name('manager.user');
            Route::post('/user/action', 'ManagerUserController@action')->name('manager.user.action');

            // Manager  Gaji Karyawan
            Route::get('/gaji-karyawan', 'ManagerGajiKaryawanController@index')->name('manager.gajikaryawan');
            Route::post('/gaji-karyawan', 'ManagerGajiKaryawanController@action')->name('manager.gajikaryawan.action');

            // Manager Rekening
            Route::get('/rekening', 'RekeningController@index')->name('manager.rekening');
            Route::post('/rekening', 'RekeningController@action')->name('manager.rekening.action');
        });

        Route::group(['middleware' => ['role:admin|pengepak']], function(){
            // Manager Barang
            Route::get('/barang', 'ManagerBarangController@index')->name('manager.barang');
            Route::post('/barang', 'ManagerBarangController@action')->name('manager.barang.action');
        });

        Route::group(['middleware' => ['role:admin|pengepak']], function(){
            // Manager Barang Mentah
            Route::get('/barang-mentah', 'ManagerBarangMentahController@index')->name('manager.barang_mentah');
            Route::post('/barang-mentah', 'ManagerBarangMentahController@action')->name('manager.barang_mentah.action');
        });

        Route::group(['middleware' => ['role:admin|supervisor']], function(){
            // Manager Input Barang Mentah
            Route::get('/input-barang-mentah', 'ManagerInputBarangMentahController@index')->name('manager.input_barang_mentah');
            Route::post('/input-barang-mentah', 'ManagerInputBarangMentahController@action')->name('manager.input_barang_mentah.action');
        });
    });

    Route::group(['prefix' => '/transaksi'], function(){
        Route::group(['middleware' => ['role:admin']], function(){
            Route::get('/barang-batal', 'TransaksiBatalController@index')->name('transaksi.batal');
            Route::post('/barang-batal', 'TransaksiBatalController@action')->name('transaksi.batal.action');
        });
        Route::group(['middleware' => ['role:admin|pengepak']], function(){
            Route::get('/permintaan', 'TransaksiPermintaanController@index')->name('transaksi.permintaan');
            Route::post('/permintaan', 'TransaksiPermintaanController@action')->name('transaksi.permintaan.action');
            Route::get('/barang-siap', 'TransaksiBarangSiapController@index')->name('transaksi.barang_siap');
            Route::post('/barang-siap', 'TransaksiBarangSiapController@action')->name('transaksi.barang_siap.action');
        });

        Route::group(['middleware' => ['role:admin|kurir']], function(){
            Route::get('/trace-track', 'TransaksiTraceTrackController@index')->name('transaksi.trace_track');
            Route::post('/trace-track', 'TransaksiTraceTrackController@action')->name('transaksi.trace_track.action');
        });
        Route::group(['middleware' => ['role:admin|kurir|pengepak']], function(){
            Route::get('/barang-diterima', 'TransaksiBarangDiterimaController@index')->name('transaksi.barang_diterima');
            Route::post('/barang-diterima', 'TransaksiBarangDiterimaController@action')->name('transaksi.barang_diterima.action');
            Route::get('/cod', 'TransaksiCodController@index')->name('transaksi.cod');
            Route::post('/cod', 'TransaksiCodController@action')->name('transaksi.cod.action');
        });
    });

    # BUAT INVESTOR
    Route::group(['middleware' => ['role:admin|investor']], function() {
        Route::group(['prefix' => '/investor', 'middleware' => ['role:admin|investor']], function() {
            Route::get('/dashboard', 'InvestorController@dashboard')->name('investor.dashboard');
            Route::group(['prefix' => '/transaksi-investor'], function() {
                Route::get('/', 'InvestorController@transaksi_investor')->name('investor.transaksi_investor');
                Route::get('/input', 'InvestorController@input_transaksi')->name('investor.input_transaksi');
                Route::post('/input', 'InvestorController@input_save')->name('investor.input_save');
            });
            Route::get('/keuangan', 'InvestorController@keuangan')->name('investor.keuangan');
        });
    });

    Route::group(['middleware' => ['role:admin'], 'prefix' => 'halaman'], function(){
        Route::get('/bantuan', 'HalamanBantuanController@index')->name('halaman.bantuan');
        Route::get('/bantuan/baru', 'HalamanBantuanController@baru')->name('halaman.bantuan.baru');
    });


    Route::get('/notifikasi', 'NotificationController@index')->name('notifikasi');
    Route::post('/notifikasi', 'NotificationController@action')->name('notifikasi.action');

    Route::get('/profil', 'ProfilController@index')->name('profil');
    Route::post('/profil', 'ProfilController@upload')->name('profil.upload');

    Route::get('/alamat', 'AlamatEditorController@index')->name('alamat');
    Route::post('/alamat', 'AlamatEditorController@action')->name('alamat.action');
});





Route::get('/dev/ekspedisi', function(){
    // mengambil daftar ekspedisi tersedia
    // $ekspedisi = Ekspedisi()->get();
    // return $ekspedisi;

    // contoh cek ongkos kirim - ($pengirim, $tujuan, $berat)
    $jne = Ekspedisi()->name('jne');
    dd( $jne->calculate("KABUPATEN MALANG", "KOTA JAKARTA PUSAT", 1) );
});

Route::get('/dev', function(){

    // return Transaksi::has('berhasil')->get();

    // $transaksi = \App\Models\Transaksi::create([
    //     'user_id' => auth()->user()->id,
    //     'alamat_id' => 1,
    //     'kode' => 'FAZA/ADMIN/14124125ABAD21',
    //     'metode' => 'kirim barang',
    //     'status' => 'Menunggu Konfirmasi',
    //     'log_track' => ''
    // ]);
    // $transaksiBarang = \App\Models\Transaksi::create([

    // $transaksi = \App\Models\Transaksi::findOrFail(1);
    // $transaksi->

    // \App\Models\TransaksiBarang::create([
    //     'transaksi_id' => 1,
    //     'barang_id' => 2,
    //     'stok' => 10,
    //     'catatan' => ''
    // ]);

    // return \App\Models\TransaksiTrack::create([
    //     "transaksi_id" => 1,
    //     "status" => "Proses Pengemasan"
    // ]);
    // return \App\Models\Transaksi::with('track')
    //     ->has('track')
    //     ->get();

    // Keranjang()->add(1, 10);
    // Keranjang()->add(2, 5);
    $transaksi = Keranjang()->toTransaksi('kirim barang', 1);
    if ( $transaksi === true) return "berhasil";
    return $transaksi;
    // return \App\Models\Transaksi::with('barangs', 'barangs.barang')->find(3s);
    // $delete = \App\Models\Transaksi::find(1)->delete();
    // dd($delete);
    // return Keranjang()->get();

    // $bayar = \App\Models\TransaksiBayar::create([
    //     'transaksi_id' => 1,
    //     'nominal' => 3000,
    //     'catatan' => "BCA"
    // ]);
    // dd($bayar);
    // $transaksi = \App\Models\Transaksi::with('barangs', 'barangs.barang', 'bayar');
    // return $transaksi->find(1)->barangs->sum('harga');
    // return $transaksi->find(1);

    // return Keranjang()->get();
});


// wwwwwwwwwwwwwwwwwwwwwwwwwwww
Route::get('/dev/install', function(){
    return '
        <form method="post">
            '.csrf_field().'
            <label>Pin : </label>
            <input type="text" name="pin" />
        </form>
    ';
});
Route::post('/dev/install', function(\Illuminate\Http\Request $request){
    $request->validate(['pin' => 'required']);
    if ($request->pin != '63945')  return redirect(url()->current());

    // RUN MIGRATE
    echo "[+] migrate <br>";
    Artisan::call("migrate:fresh");echo "<br>";
    echo "[+] seeder <br>";
    Artisan::call("db:seed", ['--class' => 'UsersTableSeeder']);echo "<br>";
    Artisan::call("db:seed", ['--class' => 'IndoRegionDistrictSeeder']);echo "<br>";
    Artisan::call("db:seed", ['--class' => 'IndoRegionProvinceSeeder']);echo "<br>";
    Artisan::call("db:seed", ['--class' => 'IndoRegionRegencySeeder']);echo "<br>";
    Artisan::call("db:seed", ['--class' => 'IndoRegionVillageSeeder']);echo "<br>";
    echo "[+] clear cache <br>";
    Artisan::call("cache:clear");echo "<br>";
    Artisan::call("view:clear");echo "<br>";
    Artisan::call("config:clear");echo "<br>";

    echo "-----------  SUCCESS -------------";
});
