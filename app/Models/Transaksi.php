<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';    
    protected $fillable = [
        'user_id', 'alamat_id', 'kode', 'metode', 'status', 'log_track'
    ];
    protected $appends = ['total'];

    public function barangs()
    {
        return $this->hasMany('App\Models\TransaksiBarang');
    }

    public function  getTotalAttribute()
    {
        return $this->barangs->sum('harga');
    }

    public function bayar()
    {
        return $this->hasOne('App\Models\TransaksiBayar');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function alamat()
    {
        return $this->belongsTo('App\Models\Alamat');
    }
}
