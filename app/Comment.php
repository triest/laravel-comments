<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //

    public function getChild(){
        return Comment::select(['*'])->where(['parent_id' => $this->id])->orderBy('created_at', 'desc')->get();
    }
}
