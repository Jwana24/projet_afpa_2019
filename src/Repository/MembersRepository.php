<?php

namespace App\Repository;

use App\Entity\Members;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Members|null find($id, $lockMode = null, $lockVersion = null)
 * @method Members|null findOneBy(array $criteria, array $orderBy = null)
 * @method Members[]    findAll()
 * @method Members[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MembersRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Members::class);
    }

    // Permet de vérifier que le mail inscrit est identique à l'un des mails de la base de données Allow to verify to the mail put in the field is identical to one (and one only) of the mails in the database
    public function findByEmail($email)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.mail = :val')
            ->setParameter('val', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }

    // /**
    //  * @return Members[] Returns an array of Members objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Members
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
