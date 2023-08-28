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
     * @param int $itemsPerPage
     * @param int $page
     * @param string|null $categoryName
     * @param string|null $name
     * @return float|int|mixed|string
     */
    public function getAllProductsByName(int $itemsPerPage, int $page, ?string $categoryName = null, ?string $name = null)
    {
        return $this->createQueryBuilder("product")
            ->join('product.category', 'category')
            ->andWhere('category.name LIKE :categoryName')
            ->andWhere("product.name LIKE :name")
            ->setParameter("name", "%" . $name . "%")
            ->setParameter("categoryName", "%" . $categoryName . "%")
            ->setFirstResult($itemsPerPage * ($page - 1))
            ->setMaxResults($itemsPerPage)
            ->orderBy('product.name', 'DESC')
            ->getQuery()
            ->getResult();
    }
//    /**
//     * @param string $name
//     * @param int $itemsPerPage
//     * @param int $page
//     * @return float|int|mixed|string
//     */
//    public function getAllProductsByName(string $name, int $itemsPerPage, int $page): mixed
//    {
//        return $this->createQueryBuilder("product")
//            ->andWhere("product.name LIKE :name")
//            ->setParameter("name", "%" . $name . "%")
//            ->setFirstResult($itemsPerPage * ($page - 1))
//            ->setMaxResults($itemsPerPage)
//            ->getQuery()
//            ->getResult();
//    }

}