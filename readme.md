<div align="center">
    <h1>
        Harap Dibaca!
    </h1>
    <small>
        I made this only for comparison and made this project more maximal magic and in line with Laravel
    </small>
</div>

### Attention 
please....<br>
read the text above. I apologize if someone gets hurt seeing this branch. but, this branch is purely my thinking and what I have made here has references that you can see below. once again this branch of my results as a human being, it is impossible for me as a human being to hurt other humans, I apologize as much as possible, and please contact me.<br>

Aku Punya Refrensi Kenapa Saya Melakukan Ini, dan pastinya melakukan riset sebelum menggunakan suatu teknologi seperti ini, demi hasil yang baik dan pemeliharaan kode yang baik. <br>
jika punya pendapat lain silahkan kontak ^_^
<hr>

### Clone
* `git clone https://github.com/destinydeveloper/faza-fruitvegetable -b faza_tmd_vers`
* `cd faza-fruitvegetable`
* make sure the selected branch is : `faza_tmd_vers -> origin`
* `composer install`
* copy `.env.example` to `.env` and Configure Your Database
* `php artisan key:generate`
* `php artisan migrate:fresh --seeder=UserTableSeeder`
* `php artisan serve` and login with email : `admin@mail.com` and Password : `admin`
<hr>

### Update This Branch (pull)
don't forget after your update this branch with (pull), run this command :
* `composer update` 
* update configuration env [if .env changed]
<hr>

### Added - Latest (b-1.6)
- b-1.6
    * Added Concept Pattern View - (Check Admin View) (Check Guide)
    * Added New Template - Admin Material Bootstrap 4 (assets/dist|assets/vendor)
    * Rename View 
        - `layouts/app.blade.php` to `layouts/auth.blade.php`
        - `auth/*` change extends to `@extends('layouts.auth)`
- b-1.5.2
    * Update Feature - Image Helpers (Check Guide)
- b-1.5.1
    * Update Image Helpers
- b-1.5
    * Upgrade Laravel `5.8.0` to `5.8.2`
    * Update Database
- b-1.4
    * Penggatian Bahasa Inggris ke Bahasa Indonesia.
- b-1.3.1
    * New Table ~ barang, barang_mentah, gambar_barang
    * Added Relation [ER-diagram]
- b-1.3
    * New Table ~ Gambar
    * New Models ~ Gambar
    * New Package ~ `Image Intervention`
    * Add Helpers ~ `App\Helpers\Images` [Guide In Bottom]
- b-1.2.1
    * Upgrade Laravel `5.7.2` to `5.8.0`
    * Optimize `auth.role`
    * Update Route - web.php
    * Make Default Namespace Cotroller for role home page
    * New Package ~ `Laravel DebugBar`
- b-1.2
    * New Table ~ Farmers, Couriers (database\migrations\2014_10_12_000000_create_users_table.php)
    * New Models ~ Farmer, Courier (App\Models\Farmer, App\Models\Courier)
    * New Middleware ~ role (App\Http\Middleware\Authrole)
    * New Middleware ~ role, Return To Homebase
<hr>

### To Do List
* Make Auth System  [fix]
* Make Basic Front End - Assets Resource Configuration    <====
* Make Auth Front End Scafollding  <====
* Make Public Home (index)
<hr>

### Table
- System
    * migrations
- Laravel Auth
    * passwords_resets
    * users
- Custom Multi-role Auth
    * admin
    * pelanggan
    * petani
    * kurir
- Assets / Resource
    * gambar
- Barang - Main
    * barang
    * barang_mentah
    * gambar_barang

<hr>

### Reference
##### Kenapa Sebelumnya Pakai Bahasa Inggris?
* Membuat aplikasi universal, mudah dikembangkan.
* Laravel itu pakai bahasa inggris, laravel juga memudahkan bahasa inggris. Pakai Bahasa Indonesia? Yah percuma pakai laravel.
##### Mengapa Memakai Morph Dalam Membuat Auth?
Menyederhanakan tabel, karena informasi user yang sama tidak usah ditulis lagi, itu sangat membuang-buang waktu! Sebagai Contoh :
```Tabel User Admin  : id, nama, email, password
Tabel User Customer : id, nama, email, password
```
Lihat ? Kedua tabel diatas sama - sama kepentingan untuk Auth dan memiliki kolom yang sama. Seorang programmer tentunya akan memilih "penulisan yang sangat malas". Maka disini saya menyarankan menggunakan polymorp relation. 
```Tabel Users : id, nama, email, password, role_type, role_id
Tabel Admin : id, code, etc
Tabel Customer : id, transaksi
```
Lihat? Kita tidak perlu mendesain ulang kolom yang sama.. sungguh.. itu sangat membosankan, laravel sudah menyediakan fitur nya, kenapa tidak kita gunakan?
##### Memakai Auth Sistem "role"
Mas Adian menyampaikan bahwa setiap user role memiliki halaman yang berbeda, oleh karena itu dari riset saya lebih cocok menggunakan User role dari pada Role / Permission karena jika setiap halaman user berbeda maka sudah pasti fitur nya juga berbeda.

<hr>

### Docs - Guide
#### Multi-role Auth - Create New User with role
Make New User With role Admin :
```// Model - role User
$role_model = \App\Models\Admin::created([]);

// Model - Main User
$user = new \App\User();
$user->name = 'MASTER ADMIN';
$user->email = 'admin@mail.com';
$user->password = bcrypt('admin');

// Morph Insert - role in User
$role_model->user()->save($user);
```

Get Information User Loged :
```
Auth()->user()
```


Get Information Auth Role :
```
Auth()->user()->role()
```

Get Information role - User Loged :
```
Auth()->user()->info
```

#### Middleware auth.role
role Registered :
* Admin
* Pelanggan
* Petani
* Kurir

Make Permission in route :
```
route::get('/admin', function(){
    return "this admin page, only user with role admin can see this page.";
})->middleware('auth.role:admin');
```
Make Permission to multi user role in route :
```
route::get('/extra', function(){
    return "this extra page, only user with role admin and customer can see this page.";
})->middleware('auth.role:admin,pelanggan');
```

For Auth Route Home, Redirect To HOME PAGE of USER role :
```
route::get('/home', function(){ return ''; })->middleware('auth.role:REDIRECT_HOME_PAGE');
```

#### Helpers ~ Images
Ingat! Untuk Melakukan Upload Gambar Selalu Gunakan Helpers Berikut :<br>
Helpers Berikut akan mengupload gambar ke folder yang sudah ditentukan di `.env` dan akan memecahnya menjadi dimensi lain sesuai yang ada di `.env`

Upload Image :
```
// Function
Images::upload($imageFile, $titleForDatabase, $descriptionForDatabase, $customDimension, $mergeDimension);


// Default Dimension (Only Dimension In .Env Configuration) (Env :1280x720|800x600)
// Output : original|1280x720|800x600
\App\Helpers\Images::upload($request->file('image'), null, null);


// Custom Dimension
// Output : original|100x100
\App\Helpers\Images::upload($request->file('image'), null, null, '100x100');
\App\Helpers\Images::upload($request->file('image'), 'Title Image Upload', 'Description Image Uplaod', '262x262');


// Custom Dimension and Dimension Fro .Env Configuration
// In .Env : 1280x720|800x600 and Custom : 100x100
// Ouput : original|1280x720|800x600|100x100
\App\Helpers\Images::upload($request->file('image'), null, null, '100x100', true);
```

Jika Membutuhkan Informasi Dari Gambar Yang Telah Di Upload :
```
$upload = \App\Helpers\Images::upload( $request->file('image') );
echo "Gambar Di simpan di database dengan id : " . $upload->id;
```

Image Configuration :
```
// ENV

RESOURCE_IMAGES_PATH=assets/images
RESOURCE_IMAGES_DIMENSIONS=1280x720|800x600
```
`RESOURCE_IMAGES_PATH` : Lokasi Gambar Akan Di Upload<br>
`RESOURCE_IMAGES_DIMENSIONS` : Dimensi Yang Dibutuhkan, Gambar Yang Di Upload Akan Kami Pecah Menjadi Beberapa Dimensi sesuai kebutuhan, pisahkan dimensi dengan tanda | antar dimensi. dan tanda x untuk memisahkan width dan height.



#### New Concept Pattern View
Pattern Yang Saya Buat Adalah :
```
// Struktur :
views/layouts/app.blade.php [Main Parrent]
views/layouts/parent-name.blade.php [Parrent]
view/child-name/page.blade.php [Child]

// Contoh Penerapan :
[Child : admin/home.blade.php]   =>  [Parrent : layouts/admin.blade.php]  => [Main : layouts/app.blade.php]

=>      : Extends
[]      : Blade View
```
Contoh Langsung Bisa Dilihat di Admin Dashboard.