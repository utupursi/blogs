<?php

namespace App\Interface;

use App\Entity\News;
use Symfony\Component\HttpFoundation\Request;

interface NewsServiceInterface
{
    public function getAll();

    public function create(Request $request);

    public function update(Request $request, News $news);

    public function delete(Request $request, News $news);
}
