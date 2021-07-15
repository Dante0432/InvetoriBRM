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

    /**
    * @return Product[] Returns an array of Product objects
    */
 
    public function findAll()
    {
        return $this->createQueryBuilder('product')
            ->select('
                product.id,
                productType.id as productTypeId,
                productType.name,
                product.lot,
                product.price,
                product.expiration_date as expirationDate, 
                COALESCE(SUM(sales.quantity),0) as sold,
                (product.quantity) as total,
                (product.quantity - COALESCE(SUM(
                    CASE WHEN sales.cancelled = false THEN     
                    sales.quantity ELSE 0
                    END
                ),0)) as available
                ')
            ->leftJoin('product.productType','productType')
            ->leftJoin('product.sales','sales')
            
            ->groupBy('product.id,productType.id, productType.name,product.lot,product.price,product.expiration_date,product.quantity')
            ->getQuery()
            ->getResult()
        ;
    }
}
