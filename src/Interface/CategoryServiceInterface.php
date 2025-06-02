<?php

namespace App\Interface;

use App\Entity\Category;
use Symfony\Component\HttpFoundation\Request;

interface CategoryServiceInterface
{
    public function getAll();

    public function create(Request $request);

    public function update(Request $request, Category $category);

    public function delete(Request $request, Category $category);
}
