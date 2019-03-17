<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';    
    protected $fillable = [
        'nama', 'berat', 'harga', 'catatan', 'stok', 'status', 'jenis', 'satuan_berat', 'satuan_stok'
    ];


    public function gambar()
    {
        return $this->belongsToMany('App\Models\Gambar', 'App\Models\GambarBarang');
    }
}
