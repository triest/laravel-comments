<?php


namespace App\Service;


use App\Comment;

class CommentService
{

    public function create($text, $parent_id = null)
    {
        $comment = new Comment();
        $comment->text = $text;
        $comment->parent_id = $parent_id;
        $comment->save();
        return $comment;
    }
}
