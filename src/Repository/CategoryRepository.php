<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\VarExporter\Hydrator;

/**
 * @extends ServiceEntityRepository<Category>
 *
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
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
    public function create(): Category
    {
        return new Category();
    }

    public function findTopLevelCategories(): array
    {
        return $this->getEntityManager()
            ->createQuery("SELECT a FROM App\Entity\Category  a where a.parent IS null")
            ->getResult();
    }
 public function findAllCategories(): array
    {
        return $this->getEntityManager()
            ->createQuery("SELECT a FROM App\Entity\Category a where a.parent")
            ->getResult();
        /*
         * select * from (SELECT cp.id,cp.name,cp.parent_id,cp.description
    FROM category AS cp JOIN category AS c
      ON cp.id = c.parent_id
UNION
SELECT cp.id,cp.name,cp.parent_id,cp.description
    FROM category cp ) x order by parent_id,id;
         */
    }


}
