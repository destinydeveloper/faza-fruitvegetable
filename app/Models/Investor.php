<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investor extends Model
{
    protected $table = 'investor';
    
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
