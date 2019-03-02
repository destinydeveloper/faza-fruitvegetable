<?php

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Route::get('/dev', function(){
    return "uji coba";
});
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
 * Pelanggan - Route Group
 * 
 */
Route::get('/user/{username}', 'Pelanggan\ProfileController@index');

Route::group([
    'middleware' => 'auth.role:pelanggan',
    'prefix' => '/user',
    'namespace' => 'Pelanggan'
], function(){
    Route::get('/', function(){
        return "anda sedang di home page user";
    })->name('user.home');
});



Route::get('/img', function(){
    $html = '
        <img src="'. asset('assets/images/100x100/'.Auth()->user()->avatar->path) .'" />
        <form method="post" enctype="multipart/form-data">
            '. csrf_field() .'
            <input type="file" name="image" />
            <button>go</button>
        </form>
    ';

    return $html;
});
Route::post('/img', function(\Illuminate\Http\Request $request){
    // Default Dimension (Only Dimension In .Env Configuration)
    // dd(\App\Helpers\Images::upload($request->file('image')));

    // Custom Dimension with merge Default Dimension
    dd(\App\Helpers\Images::upload($request->file('image'), null, null, '100x100', true));
});