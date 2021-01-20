<?php

namespace App\Repository;

use App\Entity\RecipeTool;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RecipeTool|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecipeTool|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecipeTool[]    findAll()
 * @method RecipeTool[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeToolRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecipeTool::class);
    }

    // /**
    //  * @return RecipeTool[] Returns an array of RecipeTool objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RecipeTool
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
