<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GambarBarang extends Model
{
    protected $table = 'gambar_barang';    
    protected $fillable = ['gambar_id', 'barang_id'];
}
