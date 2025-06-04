<?php

namespace App\Service;

use App\Entity\Category;
use App\Form\CategoryForm;
use App\Interface\CategoryRepositoryInterface;
use App\Interface\CategoryServiceInterface;
use App\Interface\NewsRepositoryInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CategoryService implements CategoryServiceInterface
{
    public function __construct(
        protected CategoryRepositoryInterface $categoryRepository,
        protected FormFactoryInterface        $formFactory,
        protected NewsRepositoryInterface     $newsRepository,
        protected ValidatorInterface          $validator
    )
    {
    }

    public function getAll(): array
    {
        return $this->categoryRepository->findAll();
    }

    public function getCategoriesWithLatestNews(): array
    {
        $categories = $this->categoryRepository->getCategoriesWithLatestNews();
        $grouped = [];

        foreach ($categories as $category) {
            $categoryId = $category['category_id'];

            if (!isset($grouped[$categoryId])) {
                $grouped[$categoryId] = [
                    'id' => $category['category_id'],
                    'title' => $category['category_name'],
                    'news' => []
                ];
            }

            $grouped[$categoryId]['news'][] = [
                'id' => $category['news_id'],
                'title' => $category['title'],
                'description' => $category['description'],
                'image' => $category['image'],
                'created_at' => $category['created_at']
            ];
        }

        return $grouped;
    }

    public function getCategoryNews(int $id, int $page)
    {
        return $this->newsRepository->getNewsByCategoryId($id, $page);
    }

    public function create(Request $request): ?array
    {
        $category = new Category();
        $form = $this->formFactory->create(CategoryForm::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->categoryRepository->create($category);
            return null;
        }

        return ['category' => $category, 'form' => $form];
    }

    public function update(Request $request, Category $category): ?array
    {
        $form = $this->formFactory->create(CategoryForm::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->categoryRepository->update($category);
            return null;
        }
        return ['category' => $category, 'form' => $form];
    }

    public function delete(Request $request, Category $category): bool
    {
        return $this->categoryRepository->delete($category);
    }
}
