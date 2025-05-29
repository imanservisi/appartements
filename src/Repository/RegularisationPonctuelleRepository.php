<?php

namespace App\Repository;

use App\Entity\RegularisationPonctuelle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RegularisationPonctuelle>
 *
 * @method RegularisationPonctuelle|null find($id, $lockMode = null, $lockVersion = null)
 * @method RegularisationPonctuelle|null findOneBy(array $criteria, array $orderBy = null)
 * @method RegularisationPonctuelle[]    findAll()
 * @method RegularisationPonctuelle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegularisationPonctuelleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RegularisationPonctuelle::class);
    }
}
