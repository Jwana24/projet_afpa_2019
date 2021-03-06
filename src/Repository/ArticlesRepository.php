<?php

namespace App\Repository;

use App\Entity\Articles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Articles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Articles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Articles[]    findAll()
 * @method Articles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticlesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Articles::class);
    }

    // We create this function to realize a custom SQL request. This function get the last 4 articles in the database
    public function last_articles()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.date_article', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }

    // Allow to realize the search on the title and the content of an article, depending on an identical word. We add pâgination and define the results at 8 per page 
    public function search($search, $offset = 0, $limit = 8)
    {
        return $this->createQueryBuilder('s')
            ->where('s.title_article LIKE :searchContent')
            ->orWhere('s.text_article LIKE :searchContent')
            ->setParameter('searchContent', '%'.$search.'%')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function searchCount($search)
    {
        return $this->createQueryBuilder('s')
            ->where('s.title_article LIKE :searchContent')
            ->orWhere('s.text_article LIKE :searchContent')
            ->setParameter('searchContent', '%'.$search.'%')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Articles[] Returns an array of Articles objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Articles
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
