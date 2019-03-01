<?php

namespace App\Repository;

use App\Entity\Posts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Posts|null find($id, $lockMode = null, $lockVersion = null)
 * @method Posts|null findOneBy(array $criteria, array $orderBy = null)
 * @method Posts[]    findAll()
 * @method Posts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Posts::class);
    }

    // To untie an id member on a post if the member doesn't exist anymore, allow to keep this post still available 
    public function setNullById($id)
    {
        return $this->createQueryBuilder('p')
            ->update()
            ->set('p.id_member_FK', 'NULL')
            ->Where('p.id_member_FK = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    // Allow to realize the search on the title and the content of a post, depending on an identical word. We add pâgination and define the results at 8 per page 
    public function search($search, $offset = 0, $limit = 8)
    {
        return $this->createQueryBuilder('s')
            ->where('s.title_post LIKE :searchContent')
            ->orWhere('s.text_post LIKE :searchContent')
            ->setParameter('searchContent', '%'.$search.'%')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function searchCount($search)
    {
        return $this->createQueryBuilder('s')
            ->where('s.title_post LIKE :searchContent')
            ->orWhere('s.text_post LIKE :searchContent')
            ->setParameter('searchContent', '%'.$search.'%')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Posts[] Returns an array of Posts objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Posts
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
