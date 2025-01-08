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

    //    /**
    //     * @return DeveloperProfile[] Returns an array of DeveloperProfile objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

       public function findOneByUser(User $user): ?DeveloperProfile
       {
           return $this->createQueryBuilder('d')
               ->andWhere('d.user = :val')
               ->setParameter('val', $user)
               ->getQuery()
               ->getOneOrNullResult()
           ;
       }
}
