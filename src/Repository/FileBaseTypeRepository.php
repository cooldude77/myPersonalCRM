<?php

namespace App\Repository;

use App\Entity\FileBaseType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FileBaseType>
 *
 * @method FileBaseType|null find($id, $lockMode = null, $lockVersion = null)
 * @method FileBaseType|null findOneBy(array $criteria, array $orderBy = null)
 * @method FileBaseType[]    findAll()
 * @method FileBaseType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FileBaseTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FileBaseType::class);
    }

    //    /**
    //     * @return FileBaseType[] Returns an array of FileBaseType objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?FileBaseType
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
