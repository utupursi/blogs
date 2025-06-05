<?php

namespace App\Repository;

use App\Entity\Comment;
use App\Interface\CommentRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Comment>
 */
class CommentRepository extends ServiceEntityRepository implements CommentRepositoryInterface
{
    public function __construct(ManagerRegistry $registry, protected EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Comment::class);
    }

    public function save(Comment $comment): Comment
    {
        $this->entityManager->persist($comment);
        $this->entityManager->flush();
        return $comment;
    }

    public function delete(Comment $comment): bool
    {
        $this->entityManager->remove($comment);
        $this->entityManager->flush();
        return true;
    }

    //    /**
    //     * @return Comment[] Returns an array of Comment objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Comment
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
