<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kurir extends Model
{
    protected $table = 'kurir';
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
