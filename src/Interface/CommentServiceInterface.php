<?php

namespace App\Interface;

use App\Entity\Comment;
use App\Entity\News;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

interface CommentServiceInterface
{
    public function addComment(Request $request, News $news): bool|FormInterface;

    public function delete(Comment $comment): bool;
}
