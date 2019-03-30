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
        Route::get('/', function(){
            return "hello";
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
    // Keranjang()->update(5, 10);
    $transaksi = Keranjang()->toTransaksi();
    if ( $transaksi === true) return "berhasil";
    return $transaksi;
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
    Artisan::call("migrate:fresh");
    echo "[+] seeder <br>";
    Artisan::call("db:seed", ['--class' => 'UsersTableSeeder']);
    Artisan::call("db:seed", ['--class' => 'IndoRegionDistrictSeeder']);
    Artisan::call("db:seed", ['--class' => 'IndoRegionProvinceSeeder']);
    Artisan::call("db:seed", ['--class' => 'IndoRegionRegencySeeder']);
    Artisan::call("db:seed", ['--class' => 'IndoRegionVillageSeeder']);
    echo "[+] clear cache <br>";
    Artisan::call("cache:clear");
    Artisan::call("view:clear");
    Artisan::call("config:clear");

    echo "-----------  SUCCESS -------------";
});