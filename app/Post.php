<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	protected $fillable= ['title','thumbnail','description','content','slug','category_id','user_id','created_at','updated_at'];
    public function category() {
    	return $this->belongsTo('App\Category');
    }

    public function comments() {
    	return $this->hasMany('App\Comment');
    }

    public function tags(){
    	return $this->belongsToMany('App\Tag','post_tags','post_id','tag_id');
    }

    public function likes(){
        return $this->belongsToMany('App\Like','post_likes','post_id','like_id');
    }

    public function dislikes(){
        return $this->belongsToMany('App\Dislike','post_dislikes','post_id','dislike_id');
    }
}
