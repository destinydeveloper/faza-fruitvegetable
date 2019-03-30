# Clone
* `git clone https://github.com/destinydeveloper/faza-fruitvegetable -b faza_c`
* copy .env.example to .env and edit db configuration | `cp .env.example .env`
* `composer install`
* `php artisan key:generate`
* Install with Faza Command in Artisan `php artisan faza:install -c` | guide in bottom


# ScreenShot
<div align="center">

![Gambar Struktur Resource](https://github.com/destinydeveloper/faza-fruitvegetable/raw/faza_c/ss_struktur_resource.png "Gambar Struktur Resource")

</div>

# Database
* Laravel System
    - migrations
* Laravel Auth
    - users
    - password_resets
* Laravel Permission
    - roles
    - permissions
    - model_has_roles
    - model_has_permissions
    - role_has_permissions
* Faza - Barang
    - barang
    - barang_mentah
    - gambar_barang
* Faza - Other
    - gambar
* Faza Auth
    - gaji_karyawan
    - notifications
    - alamat
* Indonesian Region - By Badan Pusat Statistik
    - indoregion_provinces
    - indoregion_regencies
    - indoregion_districts
    - indoregion_villages


# Docs - Guide
### Faza Artisan Command
baru saja menamabahkan artisan command console khusus untuk mempermudah develop faza.
```
// Normal Install
php artisan faza:install

// With Customize 
php artisan faza:install -c

// force install
php artisan faza:install -f

// membuat user
php artisan faza:create-user
```

### Helper - Image
Ingat! Untuk Melakukan Upload Gambar Selalu Gunakan Helpers Berikut :<br>
Helpers Berikut akan mengupload gambar ke folder yang sudah ditentukan di `.env` dan akan memecahnya menjadi dimensi lain sesuai yang ada di `.env`

Use Helper :
```
use App\Helpers\Images;
```

Atau langsung dengan global function :
```
images()->upload();
```

Upload Image :
```
// Function
Images::upload($nameInRequest, $titleForDatabase, $descriptionForDatabase, $customDimension, $mergeDimension);

//Name File Image In Request :
$image = $request->file('image');

// Default Dimension (Only Dimension In .Env Configuration) (Env :1280x720|800x600)
// Output : original|1280x720|800x600
\App\Helpers\Images::upload('image', null, null);


// Custom Dimension
// Output : original|100x100
\App\Helpers\Images::upload('image', null, null, '100x100');
\App\Helpers\Images::upload('image', 'Title Image Upload', 'Description Image Uplaod', '262x262');


// Custom Dimension and Dimension Fro .Env Configuration
// In .Env : 1280x720|800x600 and Custom : 100x100
// Ouput : original|1280x720|800x600|100x100
\App\Helpers\Images::upload('image', null, null, '100x100', true);
```

Jika Membutuhkan Informasi Dari Gambar Yang Telah Di Upload :
```
$upload = \App\Helpers\Images::upload( 'image' );
echo "Gambar Di simpan di database dengan id : " . $upload->id;
```

Image Configuration :
```
// ENV

RESOURCE_IMAGES_PATH=assets/images
RESOURCE_IMAGES_DIMENSIONS=1280x720|800x600
RESOURCE_IMAGES_MAX_SIZE=1024
RESOURCE_IMAGES_MIMES=jpeg,bmp,png
```
`RESOURCE_IMAGES_PATH` : Lokasi Gambar Akan Di Upload<br>
`RESOURCE_IMAGES_DIMENSIONS` : Dimensi Yang Dibutuhkan, Gambar Yang Di Upload Akan Kami Pecah Menjadi Beberapa Dimensi sesuai kebutuhan, pisahkan dimensi dengan tanda | antar dimensi. dan tanda x untuk memisahkan width dan height.<br>
`RESOURCE_IMAGES_MAX_SIZE` : Maksimal Ukuran Yang diperbolehkan dalam byte.<br>
`RESOURCE_IMAGES_MIMES` : Format gambar yang diperbolehkan.<br>


### Helper - Account

Use Helper :
```
use App\Helpers\Account;
```

Atau langsung dengan global function :
```
Account()->make();
```

Membuat akun :
```
make($name, $username, $email, $password, $role);
```

### Helper - Notification

Menggunakan :
```
app(App\Helpers\Image::class)
// or
notifications()
```

Mengambil notifkasi : 
```
// get login account :
account()->get();

// get spesific id user :
account()->get(1);
````

Membuat notifikasi
```
account()->make("Title", "Content", iduser, "url_if_notif_clicked", "info");
account()->make("Title", "Content", iduser, "url_if_notif_clicked", "success");
account()->make("Title", "Content", iduser, "url_if_notif_clicked", "warning");
account()->make("Title", "Content", Auth()->user()->id, "url_if_notif_clicked", "danger");
```

### Helper - RawDataGetter

Use : 
```
use App\Helpers\RawDataGetter;
```

```
// getting csv - App\Faza\csv\tes.csv
$tes = RawDataGetter::get('tes');
```

### Helper - Keranjang

lihat semua barang di keranjang :
```
// get
$keranjang = keranjang()->get();

// output 
[
    ...
    [
        id: 1,
        barang_id: 1,
        barang_nama: "tomat",
        barang_stok: 100,
        stok: 5,
        error: ""
    ]
    ...
]
```

Handle Error :
```
$keranjang = keranjang()->get();
foreach($keranjang as $barang)
{
    if ($barang->error != "") echo "Error : " . $barang->error;
}
```

Tambah Barang Ke Keranjang
```
// var
keranjang()->add($id_barang, $stok, $catatan = null);

// example
keranjang()->add(10, 5);
keranjang()->add(10, 5, "Warna Briu gan...");
```

Update 
```
// var
keranjang()->update($id_keranjang, $stok, $catatan);

// example
keranjang()->update(13, 6);
```

Delete
```
// example
keranjang()->remove(10);
```

### Helper - Ekspedisi

Semua Ekspedisi Tersedia :
```
$ekspedisi = ekspedisi()->get();
```

Cek Ongkir
```
// var
$jne = ekspedisi()->name('jne|tiki|pos');
$result = $jne->calculate($origin, $destination, $weight);

// example
$jne = ekspedisi()->name('jne');
$result = $jne->calculate("KABUPATEN MALANG", "KOTTA MOJOKERTO", 100);
```


# Credits
* Laravel 5.8
* Wilayah Indonesia - Badan Pusat Statistik (BPS) Indonesia
* Bootstrapious 