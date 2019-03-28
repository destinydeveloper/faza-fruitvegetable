<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'keranjang';
    protected $fillable = [
        'user_id', 'barang_id', 'stok', 'catatan'
    ];

    public function barang()
    {
        return $this->belongsTo('App\Models\Barang');
    }
}
