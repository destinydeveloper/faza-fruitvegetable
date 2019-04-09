<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiBayar extends Model
{
    protected $table = 'transaksi_bayar';    
    protected $fillable = [
        'transaksi_id', 'nominal', 'catatan'
    ];
}
