<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';    
    protected $fillable = [
        'user_id', 'alamat_id', 'kode', 'metode', 'status', 'log_track'
    ];
    protected $appends = ['total', 'konfirmasi'];

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

    public function dikonfirmasi()
    {
        return $this->hasOne('App\Models\TransaksiKonfirmasi');
    }

    public function getKonfirmasiAttribute()
    {
        $dikonfirmasi = $this->dikonfirmasi;
        return $dikonfirmasi == null ? false : true;
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function alamat()
    {
        return $this->belongsTo('App\Models\Alamat');
    }

    public function track()
    {
        return $this->hasMany('App\Models\TransaksiTrack');
    }

    public function berhasil()
    {
        return $this->hasOne('App\Models\TransaksiBerhasil');
    }
}
