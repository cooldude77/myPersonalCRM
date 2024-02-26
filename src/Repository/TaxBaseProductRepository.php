<?php

namespace App\Repository;

use App\Entity\TaxBaseProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TaxBaseProduct>
 *
 * @method TaxBaseProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaxBaseProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaxBaseProduct[]    findAll()
 * @method TaxBaseProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaxBaseProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaxBaseProduct::class);
    }

    //    /**
    //     * @return TaxBaseProduct[] Returns an array of TaxBaseProduct objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?TaxBaseProduct
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
