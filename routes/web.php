<?php
use Illuminate\Http\Request;

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



Route::post('/img', function(Request $request){
    $request->validate([
        'image' => 'required|image|mimes:jpg,png,jpeg'
    ]);

    $path = asset('assets/images/');
    $file = $request->file('image');
    $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    \Image::make($file)->save($path . '/' . 'original' . '/' . $fileName);
});