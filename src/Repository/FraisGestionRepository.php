<?php

namespace App\Repository;

use App\Entity\FraisGestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FraisGestion>
 *
 * @method FraisGestion|null find($id, $lockMode = null, $lockVersion = null)
 * @method FraisGestion|null findOneBy(array $criteria, array $orderBy = null)
 * @method FraisGestion[]    findAll()
 * @method FraisGestion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FraisGestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FraisGestion::class);
    }

//    /**
//     * @return FraisGestion[] Returns an array of FraisGestion objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FraisGestion
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
