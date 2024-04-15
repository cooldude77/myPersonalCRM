<?php

namespace App\Repository;

use App\Entity\CategoryFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategoryFile>
 *
 * @method CategoryFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryFile[]    findAll()
 * @method CategoryFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryFileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryFile::class);
    }

    //    /**
    //     * @return CategoryFile[] Returns an array of CategoryFile objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?CategoryFile
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function create(\App\Entity\File     $file,
                           \App\Entity\Category $category): CategoryFile
    {

        $categoryFile = new CategoryFile();
        $categoryFile->setFile($file);
        $categoryFile->setCategory($category);
        return $categoryFile;
    }
}
