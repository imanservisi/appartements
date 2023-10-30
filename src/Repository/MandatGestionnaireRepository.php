<?php

namespace App\Repository;

use App\Entity\MandatGestionnaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MandatGestionnaire>
 *
 * @method MandatGestionnaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method MandatGestionnaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method MandatGestionnaire[]    findAll()
 * @method MandatGestionnaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MandatGestionnaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MandatGestionnaire::class);
    }

//    /**
//     * @return MandatGestionnaire[] Returns an array of MandatGestionnaire objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MandatGestionnaire
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
