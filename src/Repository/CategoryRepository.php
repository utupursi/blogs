<?php

namespace App\Repository;

use App\Entity\Category;
use App\Interface\CategoryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 */
class CategoryRepository extends ServiceEntityRepository implements CategoryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry, protected EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Category::class);
    }

    public function create(Category $category): Category
    {
        $this->entityManager->persist($category);
        $this->entityManager->flush();
        return $category;
    }


    public function update(Category $category): Category
    {
        $this->entityManager->flush();
        return $category;
    }

    public function delete(Category $category): bool
    {
        $this->entityManager->remove($category);
        $this->entityManager->flush();
        return true;
    }

    /**
     * @throws Exception
     */
    public function getCategoriesWithLatestNews(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "
        SELECT c.id AS category_id,
               c.title AS category_name,
               n.id AS news_id,
               n.title AS title,
               n.created_at,
               n.image,
               n.description
        FROM category c
        JOIN news_category nc ON nc.category_id = c.id
        JOIN news n ON nc.news_id = n.id
        WHERE n.created_at IS NOT NULL
        AND (
            SELECT COUNT(*)
            FROM news_category nc2
            JOIN news n2 ON nc2.news_id = n2.id
            WHERE nc2.category_id = c.id AND n2.created_at > n.created_at
        ) < :limit
        ORDER BY c.id, n.created_at DESC
    ";

        $resultSet = $conn->executeQuery($sql, ['limit' => 3]);

        return $resultSet->fetchAllAssociative();

    }

    //    /**
    //     * @return Category[] Returns an array of Category objects
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

    //    public function findOneBySomeField($value): ?Category
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
