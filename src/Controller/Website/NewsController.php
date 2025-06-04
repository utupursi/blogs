<?php

namespace App\Controller\Website;

use App\Entity\News;
use App\Interface\CategoryServiceInterface;
use App\Interface\CommentServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/')]
final class NewsController extends AbstractController
{
    #[Route('/home/category/{id}', name: 'category_news',methods: ['GET'])]
    public function getCategoryNews(Request $request, int $id, CategoryServiceInterface $categoryService): Response
    {
        return $this->render('website/news/index.html.twig', [
            'paginatedNews' => $categoryService->getCategoryNews(
                $id,
                $request->query->getInt('page', 1)
            )
        ]);
    }

    #[Route('/home/news/{id}', name: 'news_detail',methods: ['GET','POST'])]
    public function getItem(Request $request, News $news, CommentServiceInterface $commentService): Response
    {
        $form = $commentService->addComment($request, $news);

        if ($form === true) {
            return $this->redirectToRoute('news_detail', ['id' => $news->getId()]);
        }

        return $this->render('website/news/detail.html.twig', [
            'news' => $news,
            'form' => $form
        ]);
    }

    #[Route('/home/news/{id}/comments', name: 'news_comments',methods: ['GET'])]
    public function getNewsComments(News $news): Response
    {
        return $this->render('website/comment/index.html.twig', [
            'comments' => $news->getComments()
        ]);
    }
}
