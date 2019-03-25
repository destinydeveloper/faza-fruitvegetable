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
});

Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');



Route::group([
    'prefix' => 'user',
    'as' => 'user.',
    'middleware' => 'auth'
], function () {
    Route::get('/', function () {
        return view('user.home');
    })->name('home');
    Route::group(['middleware' => ['role:admin']], function(){
        // Manager User
        Route::get('/manager/user', 'ManagerUserController@index')->name('manager.user');
        Route::post('/manager/user/action', 'ManagerUserController@action')->name('manager.user.action');
        
        // Manager  Gaji Karyawan
        Route::get('/manager/gaji-karyawan', 'ManagerGajiKaryawanController@index')->name('manager.gajikaryawan');
        Route::post('/manager/gaji-karyawan', 'ManagerGajiKaryawanController@action')->name('manager.gajikaryawan.action');
    });

    Route::group(['middleware' => ['role:admin|pengepak']], function(){
        // Manager Barang
        Route::get('/manager/barang', 'ManagerBarangController@index')->name('manager.barang');
        Route::post('/manager/barang', 'ManagerBarangController@action')->name('manager.barang.action');
    });

    Route::group(['middleware' => ['role:admin|pengepak']], function(){
        // Manager Barang Mentah
        Route::get('/manager/barang-mentah', 'ManagerBarangMentahController@index')->name('manager.barang_mentah');
        Route::post('/manager/barang-mentah', 'ManagerBarangMentahController@action')->name('manager.barang_mentah.action');
    });

    Route::group(['middleware' => ['role:admin|supervisor']], function(){
        // Manager Input Barang Mentah
        Route::get('/manager/input-barang-mentah', 'ManagerInputBarangMentahController@index')->name('manager.input_barang_mentah');
        Route::post('/manager/input-barang-mentah', 'ManagerInputBarangMentahController@action')->name('manager.input_barang_mentah.action');
    });

    
    Route::get('/notifikasi', 'NotificationController@index')->name('notifikasi');
    Route::post('/notifikasi', 'NotificationController@action')->name('notifikasi.action');

    Route::get('/profil', 'ProfilController@index')->name('profil');
    Route::post('/profil', 'ProfilController@upload')->name('profil.upload');

    Route::get('/alamat', 'AlamatEditorController@index')->name('alamat');
    Route::post('/alamat', 'AlamatEditorController@action')->name('alamat.action');
});




Route::get('/dev', function(){
    return view('coba');


    $url = 'http://mfdonline.bps.go.id/index.php?link=hasil_pencarian';
    $payload = [
        'pilihcari' => 'desa',
        'kata_kunci' => 'kedung ma'
    ];
    
    $session = curl_init();
    curl_setopt($session, CURLOPT_URL, $url);
    curl_setopt($session, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($session, CURLOPT_POSTFIELDS, "pilihcari=kec&kata_kunci=sooko");
    $hasil = curl_exec($session);
    curl_close($session);

    return $hasil;
});