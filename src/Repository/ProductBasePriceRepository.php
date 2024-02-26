<?php

namespace App\Repository;

use App\Entity\ProductBasePrice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductBasePrice>
 *
 * @method ProductBasePrice|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductBasePrice|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductBasePrice[]    findAll()
 * @method ProductBasePrice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductBasePriceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductBasePrice::class);
    }

//    /**
//     * @return ProductBasePrice[] Returns an array of ProductBasePrice objects
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

//    public function findOneBySomeField($value): ?ProductBasePrice
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
