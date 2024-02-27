<?php

namespace App\Repository;

use App\Entity\OrderItemPriceBreakup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderItemPriceBreakup>
 *
 * @method OrderItemPriceBreakup|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderItemPriceBreakup|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderItemPriceBreakup[]    findAll()
 * @method OrderItemPriceBreakup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderItemPriceBreakupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderItemPriceBreakup::class);
    }

    //    /**
    //     * @return OrderItemPriceBreakup[] Returns an array of OrderItemPriceBreakup objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('o.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?OrderItemPriceBreakup
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
