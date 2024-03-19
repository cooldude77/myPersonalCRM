<?php

namespace App\Repository;

use App\Entity\ProductImageFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductImageFile>
 *
 * @method ProductImageFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductImageFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductImageFile[]    findAll()
 * @method ProductImageFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductImageFileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductImageFile::class);
    }

    //    /**
    //     * @return ProductImageFile[] Returns an array of ProductImageFile objects
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

    //    public function findOneBySomeField($value): ?ProductImageFile
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
