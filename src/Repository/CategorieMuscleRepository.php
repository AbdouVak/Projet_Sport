<?php

namespace App\Repository;

use App\Entity\CategorieMuscle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategorieMuscle>
 *
 * @method CategorieMuscle|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieMuscle|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieMuscle[]    findAll()
 * @method CategorieMuscle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieMuscleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieMuscle::class);
    }

    public function topicByCategorie(){

    }
//    /**
//     * @return CategorieMuscle[] Returns an array of CategorieMuscle objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CategorieMuscle
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
