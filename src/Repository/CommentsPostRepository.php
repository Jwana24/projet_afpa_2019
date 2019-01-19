<?php

namespace App\Repository;

use App\Entity\CommentsPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CommentsPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentsPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentsPost[]    findAll()
 * @method CommentsPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentsPostRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CommentsPost::class);
    }

    // /**
    //  * @return CommentsPost[] Returns an array of CommentsPost objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CommentsPost
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
