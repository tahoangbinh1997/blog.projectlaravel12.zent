<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dislike extends Model
{
    protected $table = 'dislikes';
    protected $fillable = ['ip_client'];

    public function posts(){
    	return $this->belongsToMany('App\Post','post_dislikes','like_id','post_id');
    }
}
