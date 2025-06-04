<?php

namespace App\Controller\Website;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\News;
use App\Interface\CategoryServiceInterface;
use App\Interface\CommentServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/comments')]
final class CommentController extends AbstractController
{
    #[Route('/delete/{id}', name: 'delete_comment',methods: ['POST'])]
    public function delete(Request $request, Comment $comment, CategoryServiceInterface $categoryService): Response
    {
//        return $this->render('website/news/index.html.twig', [
//            'paginatedNews' => $categoryService->getCategoryNews(
//                $id,
//                $request->query->getInt('page', 1)
//            )
//        ]);
    }
}
