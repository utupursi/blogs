<?php

namespace App\Controller\Admin;

use App\Entity\News;
use App\Interface\NewsServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/news')]
#[IsGranted('ROLE_ADMIN')]
final class NewsController extends AbstractController
{
    #[Route(name: 'admin_news_index', methods: ['GET'])]
    public function index(NewsServiceInterface $newsService): Response
    {
        return $this->render('admin/news/index.html.twig', [
            'news' => $newsService->getAll(),
        ]);
    }

    #[Route('/new', name: 'admin_news_new', methods: ['GET', 'POST'])]
    public function new(Request $request, NewsServiceInterface $newsService): Response
    {
        $result = $newsService->create($request);
        if ($result === null) {
            return $this->redirectToRoute('admin_news_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/news/new.html.twig', [
            'news' => $result['news'],
            'form' => $result['form'],
        ]);

    }

    #[Route('/{id}', name: 'admin_news_show', methods: ['GET'])]
    public function show(News $news): Response
    {
        return $this->render('admin/news/show.html.twig', [
            'news' => $news,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_news_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request              $request,
        News                 $news,
        NewsServiceInterface $newsService
    ): Response
    {
        $result = $newsService->update($request, $news);
        if ($result == null) {
            return $this->redirectToRoute('admin_news_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/news/edit.html.twig', [
            'news' => $result['news'],
            'form' => $result['form'],
        ]);
    }

    #[Route('/{id}', name: 'admin_news_delete', methods: ['POST'])]
    public function delete(
        Request              $request,
        News                 $news,
        NewsServiceInterface $newsService
    ): Response
    {
        if ($this->isCsrfTokenValid(
            'delete' . $news->getId(),
            $request->getPayload()->getString('_token')
        )) {
            $newsService->delete($request, $news);
        }

        return $this->redirectToRoute('admin_news_index', [], Response::HTTP_SEE_OTHER);
    }
}
