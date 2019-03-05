<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengepak extends Model
{
    protected $table = 'pengepak';
    
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
