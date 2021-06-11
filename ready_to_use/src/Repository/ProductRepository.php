<?php

namespace App\Repository;

use App\Entity\Brand;
use App\Entity\Feature;
use App\Entity\Model;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

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


    /**
     * @param $model
     * @param $maxPrice
     * @return array
     */
    public function findWithFilters($model, $maxPrice): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere("p.price < :max_price")
            ->andWhere("p.model = :model")
            ->setParameter( "model" , $model)
            ->setParameter("max_price", $maxPrice)
            ->getQuery()
            ->getResult()
            ;
    }
}
