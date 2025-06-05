<?php

namespace App\Interface;

use App\Entity\Comment;

interface CommentRepositoryInterface
{
    public function save(Comment $comment): Comment;

    public function delete(Comment $comment): bool;
}
