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
            ->andWhere('d.user = :val')
            ->setParameter('val', $user)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findByUserIntId(int $user): ?DeveloperProfile
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.user = :val')
            ->setParameter('val', $user)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findLatestDevelopers(): array
    {
        return $this->createQueryBuilder('dp')
            ->join('dp.user', 'u') // Relation entre DeveloperProfile et User
            ->orderBy('u.createdAt', 'DESC') // Utilisation de createdAt de User
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }
}
