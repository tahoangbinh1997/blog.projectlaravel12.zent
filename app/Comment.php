<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = ['name','email','comments_pic','message','user_id','post_id','remember_token'];
}
