<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    public function posts(){
    	return $this->belongsToMany(Posts::class, 'post_categories', 'categories_id', 'posts_id');
    }
}
