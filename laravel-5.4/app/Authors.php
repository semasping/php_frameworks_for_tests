<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Authors extends Model
{
    public function posts(){
    	return $this->hasMany(Posts::class, 'author_id');
    }
}
