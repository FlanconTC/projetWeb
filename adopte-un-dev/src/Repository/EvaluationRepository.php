<?php

namespace App\Repository;

use App\Entity\Evaluation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Evaluation>
 */
class EvaluationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evaluation::class);
    }

    //    /**
    //     * @return Evaluation[] Returns an array of Evaluation objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

       public function findOneByUser($id)
       {
        return $this->createQueryBuilder('e')
        ->select('COUNT(e.id) as count, SUM(e.rating) as sum') // Calcul des agrégats
        ->andWhere('e.evaluatee = :user') // Condition sur l'utilisateur
        ->setParameter('user', $id) // Binding de la variable
        ->getQuery()
        ->getResult();
       }
}
