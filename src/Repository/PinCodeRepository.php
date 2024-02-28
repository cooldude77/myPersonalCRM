<?php

namespace App\Repository;

use App\Entity\PinCode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PinCode>
 *
 * @method PinCode|null find($id, $lockMode = null, $lockVersion = null)
 * @method PinCode|null findOneBy(array $criteria, array $orderBy = null)
 * @method PinCode[]    findAll()
 * @method PinCode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PinCodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PinCode::class);
    }

    //    /**
    //     * @return PinCode[] Returns an array of PinCode objects
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

    //    public function findOneBySomeField($value): ?PinCode
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
