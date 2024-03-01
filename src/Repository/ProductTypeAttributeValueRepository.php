<?php

namespace App\Repository;

use App\Entity\ProductTypeAttributeValue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductTypeAttributeValue>
 *
 * @method ProductTypeAttributeValue|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductTypeAttributeValue|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductTypeAttributeValue[]    findAll()
 * @method ProductTypeAttributeValue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductTypeAttributeValueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductTypeAttributeValue::class);
    }

    //    /**
    //     * @return ProductTypeAttributeValue[] Returns an array of ProductTypeAttributeValue objects
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

    //    public function findOneBySomeField($value): ?ProductTypeAttributeValue
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
