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
            SELECT u.username FROM 
            user u, favorites f
            WHERE f.user_id = :user_id AND (f.favorite_developer_id = u.id OR f.favorite_job_id = u.id)
            ORDER BY f.user_id ASC
            ';

        $resultSet = $conn->executeQuery($sql, ['user_id' => $id]);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }
    public function findUserExceptId(int $id): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT * FROM `user` 
        WHERE id != :user_id AND id NOT IN (
        SELECT f.favorite_developer_id 
        FROM favorites f 
        where f.user_id = :user_id);
        ';


        $resultSet = $conn->executeQuery($sql, ['user_id' => $id]);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }
}
