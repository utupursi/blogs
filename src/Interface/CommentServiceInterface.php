<?php

namespace App\Interface;

use App\Entity\News;
use Symfony\Component\HttpFoundation\Request;

interface CommentServiceInterface
{
    public function addComment(Request $request,News $news);
}
