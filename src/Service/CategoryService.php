<?php

namespace App\Service;

use App\Entity\Category;
use App\Form\CategoryForm;
use App\Interface\CategoryRepositoryInterface;
use App\Interface\CategoryServiceInterface;
use App\Interface\NewsRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

final class CategoryService implements CategoryServiceInterface
{
    public function __construct(
        protected CategoryRepositoryInterface $categoryRepository,
        protected FormFactoryInterface        $formFactory,
        protected NewsRepositoryInterface     $newsRepository,
    )
    {
    }

    public function getAll(): array
    {
        return $this->categoryRepository->findAll();
    }

    public function getCategoryNews(int $id,int $page)
    {
        return $this->newsRepository->getNewsByCategoryId($id,$page);
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
