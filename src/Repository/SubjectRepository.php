<?php

namespace App\Repository;

use App\Entity\Subject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Subject|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subject|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subject[]    findAll()
 * @method Subject[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subject::class);
    }

    /**
     * @return Subject[] Returns an array of Subject objects
     */
    public function sortByIDAsc()
    {
        return $this->createQueryBuilder('subject')
            ->orderBy('subject.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Subject[] Returns an array of Student objects
     */
    public function sortByIDDesc()
    {
        return $this->createQueryBuilder('subject')
            ->orderBy('subject.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Subject[] Returns an array of Subject objects
     */
    public function sortByNameAsc()
    {
        return $this->createQueryBuilder('subject')
            ->orderBy('subject.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Subject[] Returns an array of Subject objects
     */
    public function sortByNameDesc()
    {
        return $this->createQueryBuilder('subject')
            ->orderBy('subject.name', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Subject[] Returns an array of Subject objects
     */
    public function searchSubject($keyword)
    {
        return $this->createQueryBuilder('subject')
            ->andWhere('subject.name LIKE :keyword')
            ->setParameter('keyword', '%' . $keyword . '%')
            ->orderBy('subject.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Subject[] Returns an array of Subject objects
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
    public function findOneBySomeField($value): ?Subject
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
