<?php

namespace App\Controller\Website;

use App\Interface\CategoryServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/')]
final class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage',methods: ['GET'])]
    public function index(CategoryServiceInterface $categoryService): Response
    {
        $categories = $categoryService->getCategoriesWithLatestNews();
        return $this->render('website/main.html.twig', [
            'categories' => $categories,
        ]);
    }
}
