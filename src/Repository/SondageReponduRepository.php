<?php

namespace App\Repository;

use App\Entity\SondageRepondu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SondageRepondu|null find($id, $lockMode = null, $lockVersion = null)
 * @method SondageRepondu|null findOneBy(array $criteria, array $orderBy = null)
 * @method SondageRepondu[]    findAll()
 * @method SondageRepondu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SondageReponduRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SondageRepondu::class);
    }

    // /**
    //  * @return SondageRepondu[] Returns an array of SondageRepondu objects
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
    public function findOneBySomeField($value): ?SondageRepondu
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
