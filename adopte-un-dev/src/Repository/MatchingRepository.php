<?php

namespace App\Repository;

use App\Entity\Matching;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Matching>
 */
class MatchingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Matching::class);
    }

    public function findOneByCouple($dev, $entreprise): ?Matching
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.jobPost = :valE')
            ->andWhere('m.developer = :val')
            ->setParameter('val', $dev)
            ->setParameter('valE', $entreprise)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
