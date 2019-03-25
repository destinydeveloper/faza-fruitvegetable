<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    protected $fillable = [
        'user_id', 'alamat', 'penerima', 'no_telp', 'kodepos', 'alamat_lengkap'
    ];

    protected $table = 'alamat';
}
