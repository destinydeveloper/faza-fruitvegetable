<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiBukti extends Model
{
    protected $table = 'transaksi_bukti';
    protected $fillable = ['transaksi_id', 'gambar_id'];
}
