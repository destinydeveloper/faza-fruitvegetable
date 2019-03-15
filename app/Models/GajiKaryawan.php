<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GajiKaryawan extends Model
{
    protected $table = 'gaji_karyawan';
    protected $fillable = ['user_id', 'gaji_pokok', 'tunjangan', 'bonus'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
