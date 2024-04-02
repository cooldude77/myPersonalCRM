<?php

namespace App\Repository;

use App\Entity\WebShopImageFile;
use App\Entity\WebShopImageType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WebShopImageFile>
 *
 * @method WebShopImageFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method WebShopImageFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method WebShopImageFile[]    findAll()
 * @method WebShopImageFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WebShopImageFileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WebShopImageFile::class);
    }

    //    /**
    //     * @return WebShopImageFile[] Returns an array of WebShopImageFile objects
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

    //    public function findOneBySomeField($value): ?WebShopImageFile
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function create(
        \App\Entity\WebShopFile $webShopFileEntity,
                           WebShopImageType $webShopImageType)
    {

        $webShopImageEntity = new WebShopImageFile();
        $webShopImageEntity->setWebShopFile($webShopFileEntity);
        $webShopImageEntity->setWebShopImageType($webShopImageType);

        return $webShopImageEntity;
    }
}
