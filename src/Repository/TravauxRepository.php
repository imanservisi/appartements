<?php

namespace App\Repository;

use App\Entity\Travaux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Travaux>
 *
 * @method Travaux|null find($id, $lockMode = null, $lockVersion = null)
 * @method Travaux|null findOneBy(array $criteria, array $orderBy = null)
 * @method Travaux[]    findAll()
 * @method Travaux[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TravauxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Travaux::class);
    }

   /**
    * @return Travaux[] Returns an array of Travaux objects
    */
   public function findByLotsIdAndYear($lotsId, string $annee): array
   {
        return $this->createQueryBuilder('t')
            ->where('t.lot IN (:listIds)')
           ->andWhere('t.annee = :annee')
           ->setParameter('listIds', $lotsId)
           ->setParameter('annee', $annee)
           ->orderBy('t.dateTravaux', 'ASC')
           ->getQuery()
           ->getResult()
       ;
   }
}
