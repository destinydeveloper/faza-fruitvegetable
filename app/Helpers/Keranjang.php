<?php

namespace App\Helpers;

use App\User;
use App\Models\Keranjang as modelKeranjang;
use App\Models\Barang;

class Keranjang {
    public function add($barang_id, $stok, $catatan = null)
    {
        $barang = Barang::findOrFail($barang_id);
        $keranjang = modelKeranjang::create([
            'barang_id' => $barang->id,
            'user_id' => Auth()->user()->id,
            'stok' => $stok,
            'catatan' => $catatan,
        ]);

        return $keranjang;
    }

    public function get()
    {
        $keranjang = User::with('keranjang', 'keranjang.barang')
            ->find(Auth()->user()->id)->keranjang;
        return $keranjang;
    }
}