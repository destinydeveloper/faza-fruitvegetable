<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    
    /**
     * Morph Relation
     * 
     * @return  morphOne($userModel, collumMorph)
     */
    public function user()
    {
        return $this->morphOne('App\User', 'role');
    }
}
