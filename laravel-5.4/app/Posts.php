<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    public function author(){
    	return $this->belongsTo(Authors::class, 'author_id');
    }
	public function postType(){
		return $this->belongsTo(PostTypes::class, 'post_type_id');
	}
	public function categories(){
		return $this->belongsToMany(Categories::class, 'post_categories', 'posts_id', 'categories_id');
	}
}
