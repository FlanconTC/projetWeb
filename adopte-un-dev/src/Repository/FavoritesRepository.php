<?php

namespace App\Repository;

use App\Entity\Favorites;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Favorites>
 */

class FavoritesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Favorites::class);
    }

    public function findByUserId(int $id): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
            SELECT u.username, f.favorite_developer_id, f.favorite_job_id ,j.title  FROM 
            user u, favorites f, job_post j
            WHERE f.user_id = :user_id AND (f.favorite_developer_id = u.id OR f.favorite_job_id = u.id)
            ORDER BY f.user_id ASC
            ';

        $resultSet = $conn->executeQuery($sql, ['user_id' => $id]);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }
    public function findAddableUser(int $id): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT u.username, u.id
        FROM user u
        WHERE u.id NOT IN (
        SELECT f.user_id
        FROM favorites f 
        WHERE f.user_id != :user_id) AND u.id != :user_id;
        ';


        $resultSet = $conn->executeQuery($sql, ['user_id' => $id]);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }
    public function findAddablePost(int $id): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT j.title, j.id
        FROM job_post j
        WHERE j.company_id NOT IN (
        SELECT f.user_id
        FROM favorites f 
        WHERE f.user_id = :user_id) and j.company_id != :user_id;
        ';


        $resultSet = $conn->executeQuery($sql, ['user_id' => $id]);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }
}
