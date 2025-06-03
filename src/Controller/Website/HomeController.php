<?php

namespace App\Controller\Website;

use App\Entity\Category;
use App\Interface\CategoryServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/home/category/{id}')]
    public function getCategoryNews(Request $request,int $id, CategoryServiceInterface $categoryService): Response
    {
        return $this->render('website/news/index.html.twig', [
            'paginatedNews' =>  $categoryService->getCategoryNews(
                $id,
                $request->query->getInt('page',1)
            )
        ]);
    }
}
