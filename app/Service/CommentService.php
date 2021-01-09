<?php


namespace App\Service;


use App\Comment;
use App\User;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;


class CommentService
{

    public function getAll()
    {
        return Comment::select(['*'])->get();
    }

    public function getRoot()
    {
        return Comment::select(['*'])->where(['parent_id' => null])->with('user')->orderBy('created_at', 'desc')->get();
    }

    public function getChild()
    {
        return Comment::select(['*'])->whereNotNull(['parent_id'])->with('user')->orderBy('created_at', 'desc')->get();
    }

    public function create($text, $parent_id = null)
    {

       $user = Auth::user();

        if ($user == null) {
           $user=User::select('*')->first();
           if($user==null){
               return ;
           }
            Auth::login($user);
        }

        $comment = new Comment();
        $comment->text = $text;
        $comment->parent_id = $parent_id;
        $comment->save();

        $user->comment()->save($comment);
    //    $comment->user()->save($user);

        return $comment;
    }
}
