<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiBerhasil extends Model
{
    protected $table = 'transaksi_berhasil';
    protected $fillable = ['transaksi_id', 'penerima', 'pengantar'];
}
