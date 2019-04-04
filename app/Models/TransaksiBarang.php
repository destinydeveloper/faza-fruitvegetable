<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiBarang extends Model
{
    protected $table = 'transaksi_barang';    
    protected $fillable = [
        'transaksi_id', 'barang_id', 'stok', 'catatan'
    ];

    public function barang()
    {
        return $this->belongsTo('App\Models\Barang');
    }
}
