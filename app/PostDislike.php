<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostDislike extends Model
{
    protected $table = 'post_dislikes';
    protected $fillable = ['dislike_id','post_id','remember_token'];
}
