<?php

namespace App\Repository;

use App\Entity\WebShopHomeSection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WebShopHomeSection>
 *
 * @method WebShopHomeSection|null find($id, $lockMode = null, $lockVersion = null)
 * @method WebShopHomeSection|null findOneBy(array $criteria, array $orderBy = null)
 * @method WebShopHomeSection[]    findAll()
 * @method WebShopHomeSection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WebShopHomeSectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WebShopHomeSection::class);
    }

    //    /**
    //     * @return WebShopHomeSection[] Returns an array of WebShopHomeSection objects
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

    //    public function findOneBySomeField($value): ?WebShopHomeSection
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
