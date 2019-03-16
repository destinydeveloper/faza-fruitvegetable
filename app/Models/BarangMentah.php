<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangMentah extends Model
{
    protected $table = 'barang_mentah';    
    protected $fillable = [
        'nama', 'berat', 'harga', 'catatan', 'stok'
    ];
}
