<?php

namespace App\Repository;

use App\Entity\News;
use App\Interface\NewsRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<News>
 */
class NewsRepository extends ServiceEntityRepository implements NewsRepositoryInterface
{
    public function __construct(ManagerRegistry $registry, protected EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, News::class);
    }

    public function create(News $news): News
    {
        $this->entityManager->persist($news);
        $this->entityManager->flush();
        return $news;
    }


    public function update(News $news): News
    {
        $this->entityManager->flush();
        return $news;
    }

    public function delete(News $news): bool
    {
        $this->entityManager->remove($news);
        $this->entityManager->flush();
        return true;
    }

    //    /**
    //     * @return News[] Returns an array of News objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('n')
    //            ->andWhere('n.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('n.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?News
    //    {
    //        return $this->createQueryBuilder('n')
    //            ->andWhere('n.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
