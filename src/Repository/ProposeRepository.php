<?php

namespace App\Repository;

use App\Entity\Propose;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Propose|null find($id, $lockMode = null, $lockVersion = null)
 * @method Propose|null findOneBy(array $criteria, array $orderBy = null)
 * @method Propose[]    findAll()
 * @method Propose[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProposeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Propose::class);
    }


    // /**
    //  * @return Propose[] Returns an array of Propose objects
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
    public function findOneBySomeField($value): ?Propose
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
