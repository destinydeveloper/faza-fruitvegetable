<?php
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home')->middleware('auth.role:REDIRECT_HOME_PAGE');
Route::get('/home', 'HomeController@index')->name('home');


Route::get('/img', function(){
    return '
        <img src="'. asset('assets/images/245/1551351066_5c77bd1aae182.jpg') .'" />
        <form method="post" enctype="multipart/form-data">
            '. csrf_field() .'
            <input type="file" name="image" />
            <button>upload</button>
        </form>
    ';
});

Route::post('/img', function(Request $request){
    $request->validate([
        'image' => 'required|image|mimes:jpg,png,jpeg'
    ]);

    dd( \App\Helpers\Images::upload($request->file('image')) );
});



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