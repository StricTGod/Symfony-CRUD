<?php

namespace App\Repository;

use App\Entity\Qwerty;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Qwerty|null find($id, $lockMode = null, $lockVersion = null)
 * @method Qwerty|null findOneBy(array $criteria, array $orderBy = null)
 * @method Qwerty[]    findAll()
 * @method Qwerty[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QwertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Qwerty::class);
    }

    // /**
    //  * @return Qwerty[] Returns an array of Qwerty objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Qwerty
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
