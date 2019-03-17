<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GambarBarang extends Model
{
    protected $table = 'gambar_barang';    
    protected $fillable = ['barang_id', 'gambar_id'];
}
