<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\ProductFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductFile>
 *
 * @method ProductFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductFile[]    findAll()
 * @method ProductFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductFileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductFile::class);
    }

    //    /**
    //     * @return ProductFile[] Returns an array of ProductFile objects
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

    //    public function findOneBySomeField($value): ?ProductFile
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function create(\App\Entity\File $file, Product $product): ProductFile
    {
        $productFile =  new ProductFile();
        $productFile->setFile($file);
        $productFile->setProduct($product);

        return $productFile;
    }
}
