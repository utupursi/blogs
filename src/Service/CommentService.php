<?php

namespace App\Service;

use App\Entity\Comment;
use App\Entity\News;
use App\Form\CommentForm;
use App\Interface\CommentRepositoryInterface;
use App\Interface\CommentServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

final class CommentService implements CommentServiceInterface
{
    public function __construct(
        protected CommentRepositoryInterface $commentRepository,
        protected FormFactoryInterface       $formFactory,
        protected EntityManagerInterface     $entityManager,
    )
    {
    }

    public function addComment(Request $request, News $news): true|FormInterface
    {
        $comment = new Comment();
        $comment->setNews($news);

        $form = $this->formFactory->create(CommentForm::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commentRepository->save($comment);
            return true;
        }

        return $form;
    }
}
