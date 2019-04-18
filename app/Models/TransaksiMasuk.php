<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiMasuk extends Model
{
    protected $table = "transaksi_masuk";
    protected $fillable = [
        'barang_id', 'stok', 'total'
    ];
}
