<?php

namespace App\Repository;

use App\Entity\RegulationPonctuelle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RegulationPonctuelle>
 *
 * @method RegulationPonctuelle|null find($id, $lockMode = null, $lockVersion = null)
 * @method RegulationPonctuelle|null findOneBy(array $criteria, array $orderBy = null)
 * @method RegulationPonctuelle[]    findAll()
 * @method RegulationPonctuelle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegulationPonctuelleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RegulationPonctuelle::class);
    }

//    /**
//     * @return RegulationPonctuelle[] Returns an array of RegulationPonctuelle objects
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

//    public function findOneBySomeField($value): ?RegulationPonctuelle
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
