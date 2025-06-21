<?php

namespace App\Repository;

use App\Entity\Recapitulatif;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recapitulatif>
 *
 * @method Recapitulatif|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recapitulatif|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recapitulatif[]    findAll()
 * @method Recapitulatif[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecapitulatifRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recapitulatif::class);
    }

//    /**
//     * @return Recapitulatif[] Returns an array of Recapitulatif objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Recapitulatif
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
