<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    protected $table = 'supervisor';
    
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
