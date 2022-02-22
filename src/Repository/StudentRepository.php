<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Student|null find($id, $lockMode = null, $lockVersion = null)
 * @method Student|null findOneBy(array $criteria, array $orderBy = null)
 * @method Student[]    findAll()
 * @method Student[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }


    /**
     * @return Student[] Returns an array of Student objects
     */
    public function findPage($page, $max)
    {
        return $this->createQueryBuilder('student')
            ->orderBy('student.id', 'ASC')
            ->setFirstResult(($page - 1) * $max)
            ->setMaxResults($max)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Student[] Returns an array of Student objects
     */
    public function sortByIDAsc()
    {
        return $this->createQueryBuilder('student')
            ->orderBy('student.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Student[] Returns an array of Student objects
     */
    public function sortByIDDesc()
    {
        return $this->createQueryBuilder('student')
            ->orderBy('student.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Student[] Returns an array of Student objects
     */
    public function sortByNameAsc()
    {
        return $this->createQueryBuilder('student')
            ->orderBy('student.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Student[] Returns an array of Student objects
     */
    public function sortByNameDesc()
    {
        return $this->createQueryBuilder('student')
            ->orderBy('student.name', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Student[] Returns an array of Student objects
     */
    public function searchStudent($keyword)
    {
        return $this->createQueryBuilder('student')
            ->andWhere('student.name LIKE :keyword')
            ->setParameter('keyword', '%' . $keyword . '%')
            ->orderBy('student.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Student[] Returns an array of Student objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Student
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
