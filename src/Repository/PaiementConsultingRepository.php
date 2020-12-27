<?php

namespace App\Repository;

use App\Entity\PaiementConsulting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PaiementConsulting|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaiementConsulting|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaiementConsulting[]    findAll()
 * @method PaiementConsulting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaiementConsultingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaiementConsulting::class);
    }

    // /**
    //  * @return Paiement[] Returns an array of Paiement objects
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
    public function findOneBySomeField($value): ?Paiement
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
