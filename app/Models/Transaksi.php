<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';    
    protected $fillable = [
        'user_id', 'alamat_id', 'kode', 'metode', 'status', 'log_track'
    ];

    public function barangs()
    {
        return $this->hasMany('App\Models\TransaksiBarang');
    }
}
