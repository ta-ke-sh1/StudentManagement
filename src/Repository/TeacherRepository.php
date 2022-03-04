<?php

namespace App\Repository;

use App\Entity\Teacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
<<<<<<< HEAD
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
=======
>>>>>>> 9bdfc28bf9668fca56ed27b13668b08004cc1a50
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Teacher|null find($id, $lockMode = null, $lockVersion = null)
 * @method Teacher|null findOneBy(array $criteria, array $orderBy = null)
 * @method Teacher[]    findAll()
 * @method Teacher[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeacherRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Teacher::class);
    }

    /**
     * @return Teacher[] Returns an array of Teacher objects
     */
    public function sortByIDAsc()
    {
        return $this->createQueryBuilder('teacher')
            ->orderBy('teacher.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Teacher[] Returns an array of Teacher objects
     */
    public function sortByIDDesc()
    {
        return $this->createQueryBuilder('teacher')
            ->orderBy('teacher.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Teacher[] Returns an array of Teacher objects
     */
    public function sortByNameAsc()
    {
        return $this->createQueryBuilder('teacher')
            ->orderBy('teacher.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Teacher[] Returns an array of Teacher objects
     */
    public function sortByNameDesc()
    {
        return $this->createQueryBuilder('teacher')
            ->orderBy('teacher.name', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Teacher[] Returns an array of Teacher objects
     */
    public function searchTeacher($keyword)
    {
        return $this->createQueryBuilder('teacher')
            ->andWhere('teacher.name LIKE :keyword')
            ->setParameter('keyword', '%' . $keyword . '%')
            ->orderBy('teacher.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Teacher[] Returns an array of Teacher objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Teacher
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
