<?php

namespace App\Interface;

use App\Entity\Category;
use App\Entity\Comment;
use Symfony\Component\HttpFoundation\Request;

interface CommentRepositoryInterface
{
    public function save(Comment $comment);
}
