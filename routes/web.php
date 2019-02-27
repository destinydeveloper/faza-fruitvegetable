<?php

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home')->middleware('auth.role:REDIRECT_HOME_PAGE');
Route::get('/home', 'HomeController@index')->name('home');


/**
 * Admin - Route Group
 * 
 */
Route::group([
    'middleware' => 'auth.role:admin',
    'prefix' => '/admin',
    'namespace' => 'Admin'
], function(){
    Route::get('/', 'HomeController@index')->name('admin.home');
    Route::get('/info', 'HomeController@info')->name('admin.info');
});

/**
 * Customer - Route Group
 * 
 */
Route::group([
    'middleware' => 'auth.role:customer',
    'prefix' => '/user',
    'namespace' => 'Customer'
], function(){
    Route::get('/', 'HomeController@index')->name('user.home');
});

/**
 * Farmer - Route Group
 * 
 */
Route::group([
    'middleware' => 'auth.role:farmer',
    'prefix' => '/farmer',
    'namespace' => 'Farmer'
], function(){
    Route::get('/', 'HomeController@index')->name('farmer.home');
});

/**
 * Farmer - Route Group
 * 
 */
Route::group([
    'middleware' => 'auth.role:courier',
    'prefix' => '/courier',
    'namespace' => 'Courier'
], function(){
    Route::get('/', 'HomeController@index')->name('courier.home');
});