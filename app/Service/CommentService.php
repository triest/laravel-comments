<?php


namespace App\Service;


use App\Comment;

class CommentService
{

    public function getAll()
    {
        return Comment::select(['*'])->get();
    }

    public function getRoot()
    {
        return Comment::select(['*'])->where(['parent_id' => null])->orderBy('created_at', 'desc')->get();
    }

    public function getChild()
    {
        return Comment::select(['*'])->whereNotNull(['parent_id'])->orderBy('created_at', 'desc')->get();
    }

    public function create($text, $parent_id = null)
    {
        $comment = new Comment();
        $comment->text = $text;
        $comment->parent_id = $parent_id;
        $comment->save();
        return $comment;
    }
}
