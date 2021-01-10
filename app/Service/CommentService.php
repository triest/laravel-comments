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

    public function getRoot($order = 'popular')
    {
        if ($order == 'new') {
            return Comment::select(['*'])->where(['parent_id' => null])->with('like')->with('user')->orderBy('created_at',
                    'desc')->get();
        } elseif ($order == 'old') {
            return Comment::select(['*'])->where(['parent_id' => null])->with('like')->with('user')->orderBy('created_at',
                    'asc')->get();
        } elseif ($order == 'popular') {
            return Comment::select(['*'])->where(['parent_id' => null])->with('like')->with('user')->orderBy('rating',
                    'desc')->get();
        }
        return null;
    }

    public function getChild($order = 'popular')
    {
        if ($order == 'new') {
            return Comment::select(['*'])->whereNotNull(['parent_id'])->with('like')->with('user')->orderBy('created_at',
                    'desc')->get();
        }
        if ($order == 'old') {
            return Comment::select(['*'])->whereNotNull(['parent_id'])->with('like')->with('user')->orderBy('created_at',
                    'desc')->get();
        } elseif ($order == 'popular') {
            return Comment::select(['*'])->where(['parent_id' => null])->with('like')->with('user')->orderBy('rating',
                    'asc')->get();
        }
        return null;
    }

    public function create($text, $parent_id = null)
    {
        $user = Auth::user();

        if ($user == null) {
                return;
        }

        $comment = new Comment();
        $comment->text = $text;
        $comment->parent_id = $parent_id;
        $comment->user_id = $user->id;
        $comment->save();

        //      $user->comment()->save($comment);

        return Comment::select(['*'])->where(['id' => $comment->id])->with('user')->orderBy('created_at',
                'desc')->first();
        //    $comment->user()->save($user);


    }
}
