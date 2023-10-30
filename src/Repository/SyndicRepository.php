<?php

namespace App\Repository;

use App\Entity\Syndic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Syndic>
 *
 * @method Syndic|null find($id, $lockMode = null, $lockVersion = null)
 * @method Syndic|null findOneBy(array $criteria, array $orderBy = null)
 * @method Syndic[]    findAll()
 * @method Syndic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SyndicRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Syndic::class);
    }

//    /**
//     * @return Syndic[] Returns an array of Syndic objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Syndic
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
