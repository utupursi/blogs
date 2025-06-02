<?php

namespace App\Service;

use App\Entity\News;
use App\Form\NewsForm;
use App\Interface\NewsRepositoryInterface;
use App\Interface\NewsServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

final class NewsService implements NewsServiceInterface
{
    public function __construct(
        protected NewsRepositoryInterface $newsRepository,
        protected FormFactoryInterface    $formFactory,
        protected EntityManagerInterface  $entityManager,
    )
    {
    }

    public function getAll(): array
    {
        return $this->newsRepository->findAll();
    }

    public function create(Request $request): ?array
    {
        $news = new News();
        $form = $this->formFactory->create(NewsForm::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // handle exception if something happens during file upload
                }

                $news->setImage($newFilename);
            }
            $this->newsRepository->create($news);
            return null;
        }

        return ['news' => $news, 'form' => $form];
    }

    public function update(Request $request, News $news): ?array
    {
        $form = $this->formFactory->create(NewsForm::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->newsRepository->update($news);
            return null;
        }
        return ['news' => $news, 'form' => $form];
    }

    public function delete(Request $request, News $news): bool
    {
        return $this->newsRepository->delete($news);
    }
}
