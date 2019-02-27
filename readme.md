<div align="center">
    <h1>
        Please Read!
    </h1>
    <small>
        I made this only for comparison and made this project more maximal magic and in line with Laravel
    </small>
</div>

### Clone
* `git clone https://github.com/destinydeveloper/faza-fruitvegetable -b faza_tmd_vers`
* `cd faza-fruitvegetable`
* Selected Branch : `faza_tmd_vers -> origin`
* `composer install`
* copy `.env.example` to `.env` and Configure Your Database
* `php artisan migrate:fresh --seeder=UserTableSeeder`
* `php artisan serve` and login with email : `admin@mail.com` and Password : `admin`
<hr>

### Added - Latest (b-1.2)
- b-1.2.1
    * Upgrade Laravel `5.7.2` to `5.8.0`
    * Optimize `auth.role`
    * Update Route - web.php
    * Make Default Namespace Cotroller for role home page
- b-1.2
    * New Table ~ Farmers, Couriers (database\migrations\2014_10_12_000000_create_users_table.php)
    * New Models ~ Farmer, Courier (App\Models\Farmer, App\Models\Courier)
    * New Middleware ~ role (App\Http\Middleware\Authrole)
    * New Middleware ~ role, Return To Homebase
<hr>

### To Do List
* Make Auth System  <span style="color: red;"> <= </span>
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
    * Admins
    * Customers
    * Farmers
    * Couriers

<hr>

### Reference
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


Get Information role - User Loged :
```
Auth()->user()->info
```
#### Middleware auth.role
role Registered :
* Admin
* Customer
* Farmer
* Courier

Make Permission in route :
```
route::get('/admin', function(){
    return "this admin page, only user with role admin can see this page.";
})->middleware('auth.role:admin');
```
Make Permission to multi user role in route :
```
route::get('/admin', function(){
    return "this admin page, only user with role admin can see this page.";
})->middleware('auth.role:admin,customer');
```

For Auth Route Home, Redirect To HOME PAGE of USER role :
```
route::get('/home', function(){ return ''; })->middleware('auth.role:REDIRECT_HOME_PAGE');
```