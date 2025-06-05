<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Interface\CategoryServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
#[Route('/admin/category')]
#[IsGranted('ROLE_ADMIN')]
final class CategoryController extends AbstractController
{
    #[Route(name: 'admin_category_index', methods: ['GET'])]
    public function index(CategoryServiceInterface $categoryService): Response
    {
        return $this->render('admin/category/index.html.twig', [
            'categories' => $categoryService->getAll(),
        ]);
    }

    #[Route('/news', name: 'admin_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CategoryServiceInterface $categoryService): Response
    {
        $result = $categoryService->create($request);
        if ($result === null) {
            return $this->redirectToRoute('admin_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/category/new.html.twig', [
            'category' => $result['category'],
            'form' => $result['form'],
        ]);

    }

    #[Route('/{id}', name: 'admin_category_show', methods: ['GET'])]
    public function show(Category $category): Response
    {
        return $this->render('admin/category/show.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_category_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request                  $request,
        Category                 $category,
        CategoryServiceInterface $categoryService
    ): Response
    {
        $result = $categoryService->update($request, $category);
        if ($result == null) {
            return $this->redirectToRoute('admin_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/category/edit.html.twig', [
            'category' => $result['category'],
            'form' => $result['form'],
        ]);
    }

    #[Route('/{id}', name: 'admin_category_delete', methods: ['POST'])]
    public function delete(
        Request                  $request,
        Category                 $category,
        CategoryServiceInterface $categoryService
    ): Response
    {
        if ($this->isCsrfTokenValid(
            'delete' . $category->getId(),
            $request->getPayload()->getString('_token')
        )) {
            $categoryService->delete($request, $category);
        }

        return $this->redirectToRoute('admin_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
