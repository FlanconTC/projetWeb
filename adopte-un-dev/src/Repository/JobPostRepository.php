<?php

namespace App\Repository;

use App\Entity\JobPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<JobPost>
 */
class JobPostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JobPost::class);
    }

    //    /**
    //     * @return JobPost[] Returns an array of JobPost objects
    //     */
       public function findByCompany($comp): array
       {
           return $this->createQueryBuilder('j')
               ->andWhere('j.company = :val')
               ->setParameter('val', $comp)
               ->getQuery()
               ->getResult()
           ;
       }

       public function findOneByAll()
       {
           return $this->createQueryBuilder('j')
               ->getQuery()
               ->getResult()
           ;
       }

       public function findOneById($val)
       {
           return $this->createQueryBuilder('j')
                ->andWhere('j.id = :val')
                ->setParameter('val', $val)
                ->getQuery()
                ->getOneOrNullResult()
           ;
       }

       public function findPopularPosts(): array
       {
           return $this->createQueryBuilder('jp')
               ->join('jp.analytics', 'a')
               ->groupBy('jp.id')
               ->orderBy('SUM(a.viewCount)', 'DESC')
               ->setMaxResults(3)
               ->getQuery()
               ->getResult();
       }
   
       public function findLatestPosts(): array
       {
           return $this->createQueryBuilder('jp')
               ->orderBy('jp.createdAt', 'DESC')
               ->setMaxResults(3)
               ->getQuery()
               ->getResult();
       }
}
