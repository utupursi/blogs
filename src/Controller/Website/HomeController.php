<?php

namespace App\Controller\Website;

use App\Entity\Category;
use App\Interface\CategoryServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/')]
final class HomeController extends AbstractController
{
    #[Route('/home', name: 'homepage')]
    public function index(CategoryServiceInterface $categoryService): Response
    {
        $categories = $categoryService->getAll();
        return $this->render('website/main.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/home/category/{id}/news')]
    public function getCategoryNews(Category $category, CategoryServiceInterface $categoryService)
    {
        return ($categoryService->getCategoryNews($category));

    }
}
