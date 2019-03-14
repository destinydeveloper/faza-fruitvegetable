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
    Route::get('/manager/user', 'ManagerUserController@index')->name('manager.user');
    Route::post('/manager/user/action', 'ManagerUserController@action')->name('manager.user.action');
    Route::get('/manager/gajikaryawan', function () {})->name('manager.gajikaryawan');
    Route::get('/profil', 'ProfilController@index')->name('profil');
    Route::post('/profil', 'ProfilController@upload')->name('profil.upload');
});