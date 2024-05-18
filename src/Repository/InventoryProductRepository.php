<?php

namespace App\Repository;

use App\Entity\InventoryProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InventoryProduct>
 */
class InventoryProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InventoryProduct::class);
    }

    //    /**
    //     * @return InventoryProduct[] Returns an array of InventoryProduct objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('i.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?InventoryProduct
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function create(?\App\Entity\Product $product):InventoryProduct
    {

        $inventoryProduct = new InventoryProduct();

        $inventoryProduct->setProduct($product);

        return $inventoryProduct;
    }

    public function getQueryForSelect():Query
    {
        $dql = "SELECT i FROM App\Entity\InventoryProduct i";
        return $this->getEntityManager()->createQuery($dql);

    }
}
