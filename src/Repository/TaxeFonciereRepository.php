<?php

namespace App\Repository;

use App\Entity\TaxeFonciere;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TaxeFonciere>
 *
 * @method TaxeFonciere|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaxeFonciere|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaxeFonciere[]    findAll()
 * @method TaxeFonciere[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaxeFonciereRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaxeFonciere::class);
    }

//    /**
//     * @return TaxeFonciere[] Returns an array of TaxeFonciere objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TaxeFonciere
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
