<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    //
    public function comment(){
        return $this->hasOne(Comment::class,'comment_id','id');
    }

    public function user(){
        return $this->hasOne(User::class,'id','user_id',);
    }
}
