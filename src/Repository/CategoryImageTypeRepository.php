<?php

namespace App\Repository;

use App\Entity\CategoryImageType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategoryImageType>
 *
 * @method CategoryImageType|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryImageType|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryImageType[]    findAll()
 * @method CategoryImageType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryImageTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryImageType::class);
    }

    //    /**
    //     * @return CategoryImageType[] Returns an array of CategoryImageType objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?CategoryImageType
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
