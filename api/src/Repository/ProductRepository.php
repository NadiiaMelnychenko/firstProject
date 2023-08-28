<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @param $id
     * @param $key
     * @param $value
     * @return float|int|mixed|string
     */
    public function updateProductByField($id, $key, $value): mixed
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        return $queryBuilder->update("product", "p")
            ->set("p.$key", ":value")
            ->where("p.id = :id")
            ->setParameter("value", $value)
            ->setParameter("id", $id)
            ->getQuery()
            ->getResult();

//            $this->createQueryBuilder("product")
//
//            ->update('product.description')
//            ->set('product.description', ':value')
//            ->where('product.id = :id')
//            ->setParameter('key', $key)
//            ->setParameter('value', $value)
//            ->setParameter('id', $id)
//
//            ->getQuery()
//            ->getResult();
    }
}
