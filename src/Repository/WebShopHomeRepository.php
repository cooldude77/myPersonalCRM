<?php

namespace App\Repository;

use App\Entity\WebShopHome;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WebShopHome>
 *
 * @method WebShopHome|null find($id, $lockMode = null, $lockVersion = null)
 * @method WebShopHome|null findOneBy(array $criteria, array $orderBy = null)
 * @method WebShopHome[]    findAll()
 * @method WebShopHome[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WebShopHomeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WebShopHome::class);
    }

    //    /**
    //     * @return WebShopHome[] Returns an array of WebShopHome objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('w.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?WebShopHome
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
