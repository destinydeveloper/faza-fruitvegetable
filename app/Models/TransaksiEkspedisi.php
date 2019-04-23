<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiEkspedisi extends Model
{
    protected $table = 'transaksi_ekspedisi';
    protected $fillable = [
        'transaksi_id', 'nama', 'layanan', 'ongkir', 'tujuan'
    ];
}
