<?php

namespace App\Repository;

use App\Entity\Analytics;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Analytics>
 */
class AnalyticsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Analytics::class);
    }

    /**
     * Récupère les top profils les plus consultés
     */
    public function findTopUsers(int $limit = 10): array
    {
        return $this->createQueryBuilder('a')
            ->select('u.id as userId', 'u.username', 'SUM(a.viewCount) as viewCount', 'MAX(a.lastViewedAt) as lastViewedAt')
            ->join('a.user', 'u') // Jointure avec l'utilisateur
            ->groupBy('u.id')     // Groupement par utilisateur
            ->orderBy('viewCount', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * Récupère les top fiches de poste les plus consultées
     */
    public function findTopJobPosts(int $limit = 10): array
    {
        return $this->createQueryBuilder('a')
            ->select('j.id as jobPostId', 'j.title', 'SUM(a.viewCount) as viewCount', 'MAX(a.lastViewedAt) as lastViewedAt')
            ->join('a.jobPost', 'j') // Jointure avec la fiche de poste
            ->groupBy('j.id')        // Groupement par fiche de poste
            ->orderBy('viewCount', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
