<?php

namespace App\Repository;

use App\Entity\Engredient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Engredient>
 *
 * @method Engredient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Engredient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Engredient[]    findAll()
 * @method Engredient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EngredientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Engredient::class);
    }

//    /**
//     * @return Engredient[] Returns an array of Engredient objects
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

//    public function findOneBySomeField($value): ?Engredient
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
