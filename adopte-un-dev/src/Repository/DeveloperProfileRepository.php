<?php

namespace App\Repository;

use App\Entity\DeveloperProfile;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DeveloperProfile>
 */
class DeveloperProfileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeveloperProfile::class);
    }

    public function findOneByUser(User $user): ?DeveloperProfile
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.user_id = :val')
            ->setParameter('val', $user)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    public function findOneByUserId(int $id): ?DeveloperProfile
    {
       
        return $this->createQueryBuilder('d')
            ->andWhere('d.user = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
