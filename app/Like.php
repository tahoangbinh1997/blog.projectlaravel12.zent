<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likes';
    protected $fillable = ['ip_client'];

    public function posts(){
    	return $this->belongsToMany('App\Post','post_likes','like_id','post_id');
    }
}
