<?php

namespace App\Repository;

use App\Entity\CloudLink;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CloudLink|null find($id, $lockMode = null, $lockVersion = null)
 * @method CloudLink|null findOneBy(array $criteria, array $orderBy = null)
 * @method CloudLink[]    findAll()
 * @method CloudLink[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CloudLinkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CloudLink::class);
    }

    // /**
    //  * @return CloudLink[] Returns an array of CloudLink objects
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
    public function findOneBySomeField($value): ?CloudLink
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
