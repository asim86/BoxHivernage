<?php

namespace App\Repository;

use App\Entity\Piscine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Piscine|null find($id, $lockMode = null, $lockVersion = null)
 * @method Piscine|null findOneBy(array $criteria, array $orderBy = null)
 * @method Piscine[]    findAll()
 * @method Piscine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PiscineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Piscine::class);
    }

    // /**
    //  * @return Piscine[] Returns an array of Piscine objects
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
    public function findOneBySomeField($value): ?Piscine
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
