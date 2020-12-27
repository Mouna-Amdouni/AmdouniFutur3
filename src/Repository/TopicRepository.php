<?php

namespace App\Repository;

use App\Entity\Topic;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Topic|null find($id, $lockMode = null, $lockVersion = null)
 * @method Topic|null findOneBy(array $criteria, array $orderBy = null)
 * @method Topic[]    findAll()
 * @method Topic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TopicRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Topic::class);
    }

 

    public function getTopicsData() {
       

        
        $em = $this->getEntityManager();
        $query = $em->createQuery("SELECT t.id,t.name,t.author,u.roles FROM App\Entity\Topic t JOIN App\Entity\User u WITH t.author = u.id ");

        return $query->getResult();
    }

  
}
