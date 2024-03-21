<?php

namespace App\Repository;

use App\Entity\ProductImageType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductImageType>
 *
 * @method ProductImageType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductImageType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductImageType[]    findAll()
 * @method ProductImageType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductImageTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductImageType::class);
    }

    //    /**
    //     * @return ProductImageType[] Returns an array of ProductImageType objects
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

    //    public function findOneBySomeField($value): ?ProductImageType
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
