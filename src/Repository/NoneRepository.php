<?php

namespace App\Repository;

use App\Entity\None;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method None|null find($id, $lockMode = null, $lockVersion = null)
 * @method None|null findOneBy(array $criteria, array $orderBy = null)
 * @method None[]    findAll()
 * @method None[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NoneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, None::class);
    }

    // /**
    //  * @return None[] Returns an array of None objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?None
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
