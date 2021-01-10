<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    //

    public function getChild()
    {
        return Comment::select(['*'])->where(['parent_id' => $this->id])->orderBy('created_at', 'desc')->get();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function like()
    {
        return $this->hasMany(Like::class);
    }

    public function newLike(string $action = 'like')
    {
        $user = Auth::user();


        if ($user == null) {
            $user = User::select('*')->first();
            if ($user == null) {
                return;
            }
            Auth::login($user);
        }
        //проверим, не было ли до этого лайка
        $like = Like::select(['*'])
                ->where(['comment_id' => $this->id])
                ->where(['user_id' => $user->id])
                ->first();
        if ($like == null) {
            $like = new Like();
            $like->user_id = $user->id;
            $like->comment_id = $this->id;
            $like->value = 0;
        }
        if ($action == 'like' && $like->value < 1) {
            $like->value = $like->value + 1;
            $this->rating = $this->rating + 1;
        } elseif ($action == 'dislike' && $like->value > -1) {
            $like->value = $like->value - 1;
            $this->rating = $this->rating - 1;;
        } else {
            return false;
        }
        $this->save();
        $like->save();
        return $like;
    }
}
