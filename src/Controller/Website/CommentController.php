<?php

namespace App\Controller\Website;

use App\Entity\Comment;
use App\Interface\CommentServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/comments')]
final class CommentController extends AbstractController
{
    #[Route('/delete/{id}', name: 'delete_comment', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Comment $comment, CommentServiceInterface $commentService): Response
    {
        if ($this->isCsrfTokenValid(
            'delete' . $comment->getId(),
            $request->getPayload()->getString('_token')
        )) {
            $commentService->delete($comment);
        }

        return $this->redirectToRoute('news_comments',
            [
                'id' => $comment->getNews()->getId()
            ], Response::HTTP_SEE_OTHER);

    }
}
