<?php

namespace App\Repository;

use App\Entity\ProgramSelection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ProgramSelection|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProgramSelection|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProgramSelection[]    findAll()
 * @method ProgramSelection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProgramSelectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProgramSelection::class);
    }

    // /**
    //  * @return ProgramSelection[] Returns an array of ProgramSelection objects
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
    public function findOneBySomeField($value): ?ProgramSelection
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
