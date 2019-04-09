<?php

namespace App\Helpers;

use App\User;
use App\Models\Keranjang as modelKeranjang;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\TransaksiBarang;
use App\Models\Alamat;

class Keranjang {
    protected $error = [];

    public function __construct() {
        if (!Auth()->check()) return abort(403);
    }

    public function add($barang_id, $stok, $catatan = null)
    {
        $barang = Barang::find($barang_id);

        if ($barang == null) return false;

        $check = modelKeranjang::whereBarangId($barang_id)
            ->whereUserId(Auth()->user()->id)->first();
        if ($check == null) {
            $keranjang = modelKeranjang::create([
                'barang_id' => $barang->id,
                'user_id' => Auth()->user()->id,
                'stok' => $stok,
                'catatan' => $catatan,
            ]);
        } else {
            $stok_update = intval($check->stok) + $stok;
            if ($stok_update > $check->barang->stok) $stok_update = $check->barang->stok;
            return $this->update($check->id, $stok_update, $catatan); 
        }

        return $keranjang;
    }

    public function get()
    {
        $keranjang = User::with('keranjang', 'keranjang.barang')
            ->find(Auth()->user()->id)->keranjang;

        return $this->validation($keranjang);
    }

    public function remove($id)
    {
        $barang = modelKeranjang::find($id);
        if ($barang == null) return false;
        return $barang->delete();
    }

    public function destroy()
    {
        $barang = modelKeranjang::whereUserId(Auth()->user()->id);
        return $barang->delete();
    }

    public function update($id, $stok, $catatan = null)
    {
        $barang = modelKeranjang::find($id);
        if ($barang == null) return false;

        // if 
        if (($stok) > $barang->barang->stok) $stok = $barang->barang->stok;

        return $barang->update([
            'stok' => $stok,
            'catatan' => $catatan
        ]);
    }

    public function toTransaksi($method = "kirim barang", $alamat)
    {
        $keranjang = $this->get();
        $error = [];
        
        # cek metode pembelian
        $method_accept = ["kirim barang", "cod"];
        if (!in_array($method, $method_accept)) {
            array_push($error, "metode tidak valid");
            if (count($error) > 0) return ['error' => $error];
        }
        
        # cek keranjang
        if (count($keranjang) == 0) {
            array_push($error, "Tidak ada barang dikeranjang");
            if (count($error) > 0) return ['error' => $error];
        }
        
        # cek alamat
        $cek_alamat = Alamat::find($alamat);
        if ($cek_alamat == null or $cek_alamat === null) {
            array_push($error, "Alamat tidak valid");
            if (count($error) > 0) return ['error' => $error];
        }

        # cek ada error kah di keranjang
        foreach($keranjang as $item)
        {
            if ($item["error"] != "") {
                array_push($error, [
                    "barang" => $item["barang_nama"],
                    "barang_id" => $item["barang_id"],
                    "keranjang_id" => $item["id"],
                    "error" => $item["error"]
                ]);
            }
        }
        if (count($error) > 0) return ['error' => $error];
        
        # buat transaksi
        $transaksi = Transaksi::create([
            'user_id' => auth()->user()->id,
            'alamat_id' => $alamat,
            'kode' => $this->makeInvoiceKode(),
            'metode' => $method,
            'status' => 'Menunggu Konfirmasi',
            'log_track' => ''
        ]);
        $transaksi_id = $transaksi->id;

        # buat detail untuk transaksi
        $new = [];
        foreach($keranjang as $item)
        {
            $new[] = [
                'transaksi_id' => $transaksi_id,
                'barang_id' => $item["barang_id"],
                'stok' => $item["stok"],
                'catatan' => $item["catatan"],
                'harga' => $item["harga_per_stok"],
            ];
        }
        $transaksi_barang = TransaksiBarang::insert($new);

        # hapus keranjang
        $this->destroy();

        # return true - berhasil
        return true;
    }

    public function error()
    {
        return $this->error;
    }

    public function validation($keranjang)
    {

        $result = [];
        foreach($keranjang as $item)
        {
            $error = '';

            // cek barang null
            if($item->barang != null) {

                // check status
                if ($item->barang->status == "0") {
                    $error = 'itemHidden';
                }
                // cek stok
                if ($item->stok > $item->barang->stok) $error = "itemStockExceeded";

                array_push($result, [
                    'id' => $item->id,
                    'stok' => $item->stok,
                    'catatan' => $item->catatan,
                    'barang_id' => $item->barang->id,
                    'barang_nama' => $item->barang->nama,
                    'barang_stok' => $item->barang->stok,
                    'harga_per_stok' => $item->barang->harga,
                    'error' => $error
                ]);
            
            } else {
                // delete keranjang jika barang = null / dihapus / tidak ada
                $this->remove($item->id);
            }

        }
        return $result;
    }


    public function makeInvoiceKode()
    {
        // Available alpha caracters
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        // generate a pin based on 2 * 7 digits + a random character
        $pin = mt_rand(1000000, 9999999)
            . mt_rand(1000000, 9999999)
            . $characters[rand(0, strlen($characters) - 1)];

        // shuffle the result
        return str_shuffle($pin);
    }
}