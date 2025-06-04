<?php

namespace App\Interface;

use App\Entity\News;

interface NewsRepositoryInterface
{
    public function create(News $news): News;

    public function update(News $news): News;

    public function delete(News $news): bool;

    public function getNewsByCategoryId(int $id, int $page);
}
