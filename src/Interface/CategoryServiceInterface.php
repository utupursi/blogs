<?php

namespace App\Interface;

use App\Entity\Category;
use Symfony\Component\HttpFoundation\Request;

interface CategoryServiceInterface
{
    public function getAll();

    public function getCategoryNews(int $id, int $page);

    public function getCategoriesWithLatestNews(): array;

    public function create(Request $request): ?array;

    public function update(Request $request, Category $category): ?array;

    public function delete(Request $request, Category $category): bool;
}
