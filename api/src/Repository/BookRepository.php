<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Error;

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * @param int $itemsPerPage
     * @param int $page
     * @param array $params
     * @return float|int|mixed|string
     */
    public function getAllBooksByParams(int $itemsPerPage, int $page, array $params): mixed
    {
        $queryBuilder = $this->createQueryBuilder('book');
        $metadata = $this->_em->getClassMetadata(Book::class);

        foreach ($params as $key => $value) {
            $fieldMapping = $key == 'genre' ? 'integer' : $metadata->getTypeOfField($key);

            $min = str_starts_with($key, 'min_');
            $max = str_starts_with($key, 'max_');

            if (!isset($fieldMapping) && !$min && !$max) {
                throw new Error("Error field name");
            }

            $condition = in_array($fieldMapping, ['integer', 'decimal']) ? '=' : 'LIKE';

            if ($min || $max) {
                $key = substr($key, 4);
                $condition = $min ? '>=' : '<=';
            }

            $queryBuilder
                ->andWhere("book.$key $condition :$key")
                ->setParameter($key, $condition === 'LIKE' ? '%' . $value . '%' : $value);
        }

        return $queryBuilder
            ->setFirstResult($itemsPerPage * ($page - 1))
            ->setMaxResults($itemsPerPage)
            ->getQuery()
            ->getResult();
    }
}

//$paramMappings = [
//    'id' => ['field' => 'id', 'condition' => '='],
//    'title' => ['field' => 'title', 'condition' => 'LIKE'],
//    'author' => ['field' => 'author', 'condition' => 'LIKE'],
//    'plot' => ['field' => 'plot', 'condition' => 'LIKE'],
//    'text' => ['field' => 'text', 'condition' => 'LIKE'],
//    'date' => ['field' => 'date', 'condition' => 'LIKE'],
//    'visible' => ['field' => 'visible', 'condition' => 'LIKE'],
//    'genre' => ['field' => 'genre', 'condition' => '='],
//    'price' => ['field' => 'price', 'condition' => '='],
//    'min_price' => ['field' => 'price', 'condition' => '>='],
//    'max_price' => ['field' => 'price', 'condition' => '<='],
//];
//$metadata = $this->_em->getClassMetadata(Book::class);
//
//foreach ($params as $key => $value) {
//            if (!isset($paramMappings[$key])) {
//                throw new Error("Error field name");
//            }
//    $field = $paramMappings[$key]['field'];
//    $condition = $paramMappings[$key]['condition'];
//
//    $queryBuilder
//        ->andWhere("book.$field $condition :$key")
//        ->setParameter($key, $condition === 'LIKE' ? '%' . $value . '%' : $value);
//}

