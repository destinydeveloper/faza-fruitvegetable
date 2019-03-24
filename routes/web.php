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
    Route::get('/notifikasi', 'NotificationController@index')->name('notifikasi');
    Route::post('/notifikasi', 'NotificationController@action')->name('notifikasi.action');

    // Manager User
    Route::get('/manager/user', 'ManagerUserController@index')->name('manager.user');
    Route::post('/manager/user/action', 'ManagerUserController@action')->name('manager.user.action');
    
    // Manager  Gaji Karyawan
    Route::get('/manager/gaji-karyawan', 'ManagerGajiKaryawanController@index')->name('manager.gajikaryawan');
    Route::post('/manager/gaji-karyawan', 'ManagerGajiKaryawanController@action')->name('manager.gajikaryawan.action');

    // Manager Barang
    Route::get('/manager/barang', 'ManagerBarangController@index')->name('manager.barang');
    Route::post('/manager/barang', 'ManagerBarangController@action')->name('manager.barang.action');
    
    // Manager Barang Mentah
    Route::get('/manager/barang-mentah', 'ManagerBarangMentahController@index')->name('manager.barang_mentah');
    Route::post('/manager/barang-mentah', 'ManagerBarangMentahController@action')->name('manager.barang_mentah.action');
    
    // Manager Input Barang Mentah
    Route::get('/manager/input-barang-mentah', 'ManagerInputBarangMentahController@index')->name('manager.input_barang_mentah');
    Route::post('/manager/input-barang-mentah', 'ManagerInputBarangMentahController@action')->name('manager.input_barang_mentah.action');


    Route::get('/profil', 'ProfilController@index')->name('profil');
    Route::post('/profil', 'ProfilController@upload')->name('profil.upload');
});




Route::get('/dev', function(){
    $url = 'http://mfdonline.bps.go.id/index.php?link=hasil_pencarian';

    $session = curl_init();
    curl_setopt($session, CURLOPT_URL, $url);
    curl_setopt($session, CURLOPT_RETURNTRANSFER, 1);
    $hasil = curl_exec($session);
    curl_close($session);

    return $hasil;
    // return view('coba');
});