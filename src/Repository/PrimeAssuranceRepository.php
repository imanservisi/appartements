<?php

namespace App\Repository;

use App\Entity\PrimeAssurance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PrimeAssurance>
 *
 * @method PrimeAssurance|null find($id, $lockMode = null, $lockVersion = null)
 * @method PrimeAssurance|null findOneBy(array $criteria, array $orderBy = null)
 * @method PrimeAssurance[]    findAll()
 * @method PrimeAssurance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrimeAssuranceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PrimeAssurance::class);
    }

//    /**
//     * @return PrimeAssurance[] Returns an array of PrimeAssurance objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PrimeAssurance
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
