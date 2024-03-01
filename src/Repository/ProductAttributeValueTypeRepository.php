<?php

namespace App\Repository;

use App\Entity\ProductAttributeValueType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductAttributeValueType>
 *
 * @method ProductAttributeValueType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductAttributeValueType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductAttributeValueType[]    findAll()
 * @method ProductAttributeValueType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductAttributeValueTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductAttributeValueType::class);
    }

    //    /**
    //     * @return ProductAttributeValueType[] Returns an array of ProductAttributeValueType objects
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

    //    public function findOneBySomeField($value): ?ProductAttributeValueType
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
