<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangMentah extends Model
{
    protected $table = 'barang_mentah';    
    protected $fillable = [
        'barang_id', 'catatan', 'user_id', 'stok'
    ];

    public function barang()
    {
        return $this->belongsTo('App\Models\Barang');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
