<?php

namespace App\Controller\Website;

use App\Entity\News;
use App\Interface\NewsServiceInterface;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/')]
final class HomeController extends AbstractController
{
    #[Route('/home', name: 'homepage')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll(); // You can create a custom query for this
        return $this->render('website/main.html.twig', [
            'categories' => $categories,
        ]);
    }
}
