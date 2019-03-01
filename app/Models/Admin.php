<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';
    
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
