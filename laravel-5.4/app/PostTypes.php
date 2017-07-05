<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostTypes extends Model
{
    public function posts(){
    	return $this->hasMany( Posts::class );
    }
}
