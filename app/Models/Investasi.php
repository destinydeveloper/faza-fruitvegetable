<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investasi extends Model
{
    protected $table = 'investasi';

    protected $fillable = ['user_id', 'nominal', 'status'];

    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
