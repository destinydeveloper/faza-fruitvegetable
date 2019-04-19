<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiBatal extends Model
{
    protected $table = 'transaksi_batal';
    protected $fillable = ['transaksi_id', 'catatan'];
}
