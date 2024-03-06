<?php

namespace App\Repository;

use App\Entity\WebshopHome;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WebshopHome>
 *
 * @method WebshopHome|null find($id, $lockMode = null, $lockVersion = null)
 * @method WebshopHome|null findOneBy(array $criteria, array $orderBy = null)
 * @method WebshopHome[]    findAll()
 * @method WebshopHome[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WebshopHomeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WebshopHome::class);
    }

    //    /**
    //     * @return WebshopHome[] Returns an array of WebshopHome objects
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

    //    public function findOneBySomeField($value): ?WebshopHome
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
