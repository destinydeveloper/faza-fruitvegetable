<?php

namespace App\Helpers;

use App\User;
use App\Models\Transaksi as mdTransaksi;

class Transaksi {
    public function find($id)
    {
        return mdTransaksi::with('bayar', 'barangs', 'barangs.barang', 'dikonfirmasi', 'track')->find($id);
    }
    
    public function get($kode)
    {
        return mdTransaksi::with('bayar', 'barangs', 'barangs.barang', 'dikonfirmasi', 'track')
            ->whereKode($kode)
            ->first();
    }
}