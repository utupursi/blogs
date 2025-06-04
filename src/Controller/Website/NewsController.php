<?php

namespace App\Controller\Website;

use App\Entity\News;
use App\Interface\CategoryServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/')]
final class NewsController extends AbstractController
{
    #[Route('/home/category/{id}', name: 'category_news')]
    public function getCategoryNews(Request $request, int $id, CategoryServiceInterface $categoryService): Response
    {
        return $this->render('website/news/index.html.twig', [
            'paginatedNews' => $categoryService->getCategoryNews(
                $id,
                $request->query->getInt('page', 1)
            )
        ]);
    }

    #[Route('/home/news/{id}', name: 'news_detail')]
    public function getItem(News $news): Response
    {
        return $this->render('website/news/detail.html.twig', [
            'news' => $news
        ]);
    }
}
