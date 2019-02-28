<div align="center">
    <h1>
        Harap Dibaca!
    </h1>
    <small>
        I made this only for comparison and made this project more maximal magic and in line with Laravel
    </small>
</div>

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

### Added - Latest (b-1.4)
- b-1.4
    * Penggatian Bahasa Inggris ke Bahasa Indonesia karena ada yang tidak bisa bahasa inggris.
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
* Make Auth Front End Scafollding 
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
    * image_goods

<hr>

### Reference
##### Kenapa Sebelumnya Pakai Bahasa Inggris?
* Membuat aplikasi universal, mudah dikembangkan.
* Laravel itu pakai bahasa inggris, laravel juga memudahkan bahasa inggris. Pakai Bahasa Indonesia? Yah percuma pakai laravel.
* Aplikasi Go International ? percuma kalau mau translate indo ke inggris.
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
Upload Image :
```
\App\Helpers\Images::upload( $request->file('image') );
```

Image Configuration :
```
// ENV

RESOURCE_IMAGES_PATH=assets/images
RESOURCE_IMAGES_DIMENSIONS=245,300,500
```