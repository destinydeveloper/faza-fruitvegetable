<?php

use Illuminate\Database\Seeder;

use App\Models\Barang;
use App\Models\BarangMentah;
use App\Models\TransaksiMasuk;
use App\Models\Alamat;

class ExampleTransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // require __DIR__ . '../../app/Helpers/Keranjang.php';

        #### BUAT BARANG BARU
        // Nambah Barang
        $this->tambahBarang("Tomat", "buah", 1000, 10, 10, "gram", "sak");
        $this->tambahBarang("Kangkung", "sayur", 25000, 10, 10, "gram", "ikat");

        
        #### TRANSAKSI KELUAR
        // Buat alamat
        $alamat = Alamat::create([
            'user_id' => 1,
            'alamat' => "SUMATERA BARAT, KOTA PAYAKUMBUH, PAYAKUMBUH SELATAN, PADANG KARAMBIA
            ",
            'penerima' => "Coba",
            'no_telp' => "08214242424",
            'kodepos' => 61361,
            'alamat_lengkap' => "esfesrserser esres e",
        ]);

        //  nambah Keranjang
        // Keranjang()->add(1, 10);
        // Keranjang()->add(2, 5);

        // // buat transaksi
        // $transaksi = Keranjang()->toTransaksi('kirim barang', 1);



        #### TRANSAKSI MASUK
        // barang mentah
        $barang = BarangMentah::create([
            'barang_id' => 1,
            'user_id' => 1,
            'stok' => "200",
            'total' => 100000,
        ]);

        // konfirmasi barang mentah
        $BarangMentah = Bar angMentah::findOrFail(1);
        $transaksiMasuk = TransaksiMasuk::create([
            'barang_id' => $BarangMentah->barang_id,
            'stok' => $BarangMentah->stok,
            'total' => $BarangMentah->total,
        ]);
    }


    public function tambahBarang($nama, $jenis, $harga, $berat, $stok, $satuan_berat, $satuan_stok)
    {
        Barang::create([
            'nama' => $nama,
            'jenis' => $jenis,
            'harga' => $harga,
            'berat' => $berat,
            'stok' => $stok,
            'satuan_berat' => $satuan_berat,
            'satuan_stok' => $satuan_stok,
        ]);
    }
}
