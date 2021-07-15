<?php

namespace App\Repository;

use App\Entity\Sale;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sale|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sale|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sale[]    findAll()
 * @method Sale[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SaleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sale::class);
    }

    // /**
    //  * @return Sale[] Returns an array of Sale objects
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
    public function findOneBySomeField($value): ?Sale
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAllproducts()
    {
        return $this->createQueryBuilder('sale')
            ->select('productType.id,
                productType.name,
                product.lot,
                product.price,
                product.expiration_date as expirationDate, 
                SUM(CASE WHEN product.id is NOT NULL THEN 1 ELSE 0 END) as quantity')
            
            ->leftJoin('sale.product','product')
            ->leftJoin('product.productType','productType')
            //->where('sale.id is NULL')
            ->groupBy('product.lot,expirationDate,product.price, productType.name,productType.id')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneAvailableProduct($expirationDate,$lot,$price,$productTypeId)
    {
        //error_log(var_dump($lot));die;
        return $this->createQueryBuilder('sale')
        ->select('productType.id,
            productType.name,
            product.lot,
            product.price,
            product.expiration_date as expirationDate')
        
        ->leftJoin('sale.product','product')
        ->leftJoin('product.productType','productType')
        ->where('product.price = :price')
        ->andWhere('product.lot = :lot')
        ->andWhere('product.productType = :productType')
        ->andWhere('sale.id is NULL')
        //->setParameter('expirationDate', $expirationDate[0])
        ->setParameter('lot', $lot)
        ->setParameter('price', $price)
        ->setParameter('productType', $productTypeId)
        ->setMaxResults(1)
        //->groupBy('product.lot,expirationDate,product.price, productType.name,productType.id')
        ->getQuery()
        ->getSingleResult()
        ;
    }
}
