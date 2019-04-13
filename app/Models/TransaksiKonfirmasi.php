<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiKonfirmasi extends Model
{
    protected $table = 'transaksi_konfirmasi';
    protected $fillable = ['transaksi_id'];
}
