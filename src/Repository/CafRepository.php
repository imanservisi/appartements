<?php

namespace App\Repository;

use App\Entity\Caf;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Caf>
 *
 * @method Caf|null find($id, $lockMode = null, $lockVersion = null)
 * @method Caf|null findOneBy(array $criteria, array $orderBy = null)
 * @method Caf[]    findAll()
 * @method Caf[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CafRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Caf::class);
    }

//    /**
//     * @return Caf[] Returns an array of Caf objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Caf
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
