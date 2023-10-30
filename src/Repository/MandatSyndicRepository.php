<?php

namespace App\Repository;

use App\Entity\MandatSyndic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MandatSyndic>
 *
 * @method MandatSyndic|null find($id, $lockMode = null, $lockVersion = null)
 * @method MandatSyndic|null findOneBy(array $criteria, array $orderBy = null)
 * @method MandatSyndic[]    findAll()
 * @method MandatSyndic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MandatSyndicRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MandatSyndic::class);
    }

//    /**
//     * @return MandatSyndic[] Returns an array of MandatSyndic objects
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

//    public function findOneBySomeField($value): ?MandatSyndic
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
