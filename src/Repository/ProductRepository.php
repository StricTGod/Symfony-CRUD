<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function getProducts()
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.isHidden = :isHidden')
            ->setParameter('isHidden', false);
        return $qb->getQuery()->getResult();
    }

    public function getProductById($id)
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.id = :id')
            ->setParameter('id', $id);
        return $qb->getQuery()->getOneOrNullResult();
    }
}
