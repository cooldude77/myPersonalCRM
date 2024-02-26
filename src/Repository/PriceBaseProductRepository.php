<?php

namespace App\Repository;

use App\Entity\PriceBaseProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PriceBaseProduct>
 *
 * @method PriceBaseProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method PriceBaseProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method PriceBaseProduct[]    findAll()
 * @method PriceBaseProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PriceBaseProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PriceBaseProduct::class);
    }

    //    /**
    //     * @return PriceBaseProduct[] Returns an array of PriceBaseProduct objects
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

    //    public function findOneBySomeField($value): ?PriceBaseProduct
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
