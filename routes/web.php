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

Route::get('/', function () {
    return view('welcome');
})->name('homepage');

Auth::routes();


Route::group([
    'prefix' => 'user',
    'as' => 'user.',
    'middleware' => 'auth'
], function () {
    Route::get('/', 'UserHomeController@index')->name('home');
    
    Route::group(['prefix' => 'manager'], function(){
        Route::group(['middleware' => ['role:admin']], function(){
            // Manager User
            Route::get('/user', 'ManagerUserController@index')->name('manager.user');
            Route::post('/user/action', 'ManagerUserController@action')->name('manager.user.action');
            
            // Manager  Gaji Karyawan
            Route::get('/gaji-karyawan', 'ManagerGajiKaryawanController@index')->name('manager.gajikaryawan');
            Route::post('/gaji-karyawan', 'ManagerGajiKaryawanController@action')->name('manager.gajikaryawan.action');
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
        Route::group(['middleware' => ['role:admin|pengepak']], function(){
            Route::get('/permintaan', 'TransaksiPermintaanController@index')->name('transaksi.permintaan');
            Route::post('/permintaan', 'TransaksiPermintaanController@action')->name('transaksi.permintaan.action');
            Route::get('/barang-siap', 'TransaksiBarangSiapController@index')->name('transaksi.barang_siap');
            Route::post('/barang-siap', 'TransaksiBarangSiapController@action')->name('transaksi.barang_siap.action');
        });

        Route::group(['middleware' => ['role:admin|kurir']], function(){
            Route::get('/trace-track', 'TransaksiTraceTrackController@index')->name('transaksi.trace_track');
        });
        Route::group(['middleware' => ['role:admin|kurir|pengepak']], function(){
            Route::get('/barang-diterima', 'TransaksiBarangDiterimaController@index')->name('transaksi.barang_diterima');
            Route::post('/barang-diterima', 'TransaksiBarangDiterimaController@action')->name('transaksi.barang_diterima.action');
            Route::get('/cod', 'TransaksiCodController@index')->name('transaksi.cod');
        });
    });




    # BUAT INVESTOR
    Route::group(['middleware' => ['role:admin|investor']], function(){
        Route::group(['prefix' => '/laporan'], function(){
            // faza.com/laporan/transaksi
            Route::get('/transaksi', 'LaporanTransaksiController@index')->name('laporan.transaksi');            
        });
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
    // $jne = Ekspedisi()->name('tiki');
    // return $jne->calculate("KABUPATEN MALANG", "KOTA MOJOKERTO", 100);
});

Route::get('/dev', function(){
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

    Keranjang()->add(1, 10);
    Keranjang()->add(2, 5);
    // return \App\Models\Transaksi::with('barangs', 'barangs.barang')->find(3s);
    // $delete = \App\Models\Transaksi::find(1)->delete();
    // dd($delete);
    // return Keranjang()->get();
    $transaksi = Keranjang()->toTransaksi('kirim barang', 1);
    if ( $transaksi === true) return "berhasil";
    return $transaksi;

    // $bayar = \App\Models\TransaksiBayar::create([
    //     'transaksi_id' => 1,
    //     'nominal' => 3000,
    //     'catatan' => "BCA"
    // ]);
    // dd($bayar);
    $transaksi = \App\Models\Transaksi::with('barangs', 'barangs.barang', 'bayar');
    // return $transaksi->find(1)->barangs->sum('harga');
    return $transaksi->find(1);

    return Keranjang()->get();
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