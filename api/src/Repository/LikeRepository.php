<?php

namespace App\Repository;

use App\Entity\Like;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Like>
 *
 * @method Like|null find($id, $lockMode = null, $lockVersion = null)
 * @method Like|null findOneBy(array $criteria, array $orderBy = null)
 * @method Like[]    findAll()
 * @method Like[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LikeRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Like::class);
    }

    /**
     * @param $value
     * @return float|int|mixed|string
     */
    public function findAllByUserId($value): mixed
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.user_id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $value
     * @return float|int|mixed|string
     */
    public function findAllByBookId($value): mixed
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.book_id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }
}
