<?php

namespace App\Repository;

use App\Entity\Interet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Interet>
 *
 * @method Interet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Interet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Interet[]    findAll()
 * @method Interet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InteretRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Interet::class);
    }

//    /**
//     * @return Interet[] Returns an array of Interet objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Interet
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
