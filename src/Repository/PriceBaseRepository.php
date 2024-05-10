<?php

namespace App\Repository;

use App\Entity\PriceBase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PriceBase>
 *
 * @method PriceBase|null find($id, $lockMode = null, $lockVersion = null)
 * @method PriceBase|null findOneBy(array $criteria, array $orderBy = null)
 * @method PriceBase[]    findAll()
 * @method PriceBase[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PriceBaseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PriceBase::class);
    }

    //    /**
    //     * @return PriceBaseProduct[] Returns an array of PriceBaseProduct objects
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

    //    public function findOneBySomeField($value): ?PriceBaseProduct
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function create(?\App\Entity\Product $product, ?\App\Entity\Currency $currency): PriceBase
    {

        $price =  new PriceBase();
        $price->setProduct($product);
        $price->setCurrency($currency);
        return $price;
    }
}
