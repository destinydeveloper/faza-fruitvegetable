<?php

namespace App\Helpers;

use App\User;
use App\Models\Keranjang as modelKeranjang;
use App\Models\Barang;

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
            // dd($check->stok);
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

        return $keranjang;
    }

    public function remove($id)
    {
        $barang = modelKeranjang::find($id);
        if ($barang == null) return false;
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

    public function toTransaksi()
    {
        $keranjang = $this->get();
        $error = [];
        

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

        return count($error) == 0 ? true : $error;
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
                    'barang_id' => $item->barang->id,
                    'barang_nama' => $item->barang->nama,
                    'barang_stok' => $item->barang->stok,
                    'error' => $error
                ]);
            
            } else {
                // delete keranjang jika barang = null / dihapus / tidak ada
                $this->remove($item->id);
            }

        }
        return $result;
    }
}