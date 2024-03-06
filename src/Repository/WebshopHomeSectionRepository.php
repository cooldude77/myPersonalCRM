<?php

namespace App\Repository;

use App\Entity\WebshopHomeSection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WebshopHomeSection>
 *
 * @method WebshopHomeSection|null find($id, $lockMode = null, $lockVersion = null)
 * @method WebshopHomeSection|null findOneBy(array $criteria, array $orderBy = null)
 * @method WebshopHomeSection[]    findAll()
 * @method WebshopHomeSection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WebshopHomeSectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WebshopHomeSection::class);
    }

    //    /**
    //     * @return WebshopHomeSection[] Returns an array of WebshopHomeSection objects
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

    //    public function findOneBySomeField($value): ?WebshopHomeSection
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
