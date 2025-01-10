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

    public function findById($dev)
{
    return $this->createQueryBuilder('m')
        ->andWhere('m.developer = :dev')
        ->andWhere('m.firstToLike = :val OR m.matchScore = :score')
        ->setParameter('val', 'dev')
        ->setParameter('score', 2)
        ->setParameter('dev', $dev)
        ->getQuery()
        ->getResult();
}

    

    public function findByIdE($poste)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.jobPost = :jp')
            ->andWhere('m.firstToLike = :val OR m.matchScore = :score')
            ->setParameter('val', 'ent')
            ->setParameter('score', 2)
            ->setParameter('jp', $poste)
            ->getQuery()
            ->getResult()
        ;
    }
}
