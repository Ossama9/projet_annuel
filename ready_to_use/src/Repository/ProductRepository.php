<?php

namespace App\Repository;

use App\Entity\Brand;
use App\Entity\Feature;
use App\Entity\Model;
use App\Entity\Product;
use App\Entity\Sell;
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

    /**
     * Retourne la liste des produits vendu par des marchands dont l'offre a été acceptée
     * @return array
     */
    public function findAcceptedProducts(): array
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.sell', 's', 'WITH', 's.status = 1')
            ->andWhere('p.id = s.product')
            ->getQuery()
            ->getResult()
            ;
    }

}
