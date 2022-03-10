<?php

namespace App\Repository;

use App\Entity\ClassFGW;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ClassFGW|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClassFGW|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClassFGW[]    findAll()
 * @method ClassFGW[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClassFGWRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClassFGW::class);
    }

    /**
     * @return ClassFGW[] Returns an array of ClassFGW objects
     */
    public function sortByIDAsc()
    {
        return $this->createQueryBuilder('classFGW')
            ->orderBy('classFGW.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return ClassFGW[] Returns an array of ClassFGW objects
     */
    public function sortByIDDesc()
    {
        return $this->createQueryBuilder('classFGW')
            ->orderBy('classFGW.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return ClassFGW[] Returns an array of ClassFGW objects
     */
    public function sortByNameAsc()
    {
        return $this->createQueryBuilder('classFGW')
            ->orderBy('classFGW.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return ClassFGW[] Returns an array of ClassFGW objects
     */
    public function sortByNameDesc()
    {
        return $this->createQueryBuilder('classFGW')
            ->orderBy('classFGW.name', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return ClassFGW[] Returns an array of ClassFGW objects
     */
    public function searchClassFGW($keyword)
    {
        return $this->createQueryBuilder('classFGW')
            ->andWhere('classFGW.name LIKE :keyword')
            ->setParameter('keyword', '%' . $keyword . '%')
            ->orderBy('classFGW.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return ClassFGW[] Returns an array of ClassFGW objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ClassFGW
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
