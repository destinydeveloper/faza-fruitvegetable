<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiTrack extends Model
{
    protected $table = 'transaksi_track';    
    protected $fillable = [
        'transaksi_id', 'status'
    ];
}
