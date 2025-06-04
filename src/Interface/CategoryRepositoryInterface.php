<?php

namespace App\Interface;

use App\Entity\Category;

interface CategoryRepositoryInterface
{
    public function create(Category $category): Category;

    public function update(Category $category): Category;

    public function delete(Category $category): bool;

    public function getCategoriesWithLatestNews(): array;
}
