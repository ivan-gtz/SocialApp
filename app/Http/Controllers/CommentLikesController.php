<?php

namespace App\Http\Controllers;

use App\Models\Comment;

class CommentLikesController extends Controller
{
    public function store(Comment $comment)
    {
        $comment->like();
    }

    public function destroy(Comment $comment)
    {
        $comment->unlike();
    }
}
