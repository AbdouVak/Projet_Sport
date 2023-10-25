<?php

namespace App\Repository;

use App\Entity\SeanceExercice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SeanceExercice>
 *
 * @method SeanceExercice|null find($id, $lockMode = null, $lockVersion = null)
 * @method SeanceExercice|null findOneBy(array $criteria, array $orderBy = null)
 * @method SeanceExercice[]    findAll()
 * @method SeanceExercice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeanceExerciceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SeanceExercice::class);
    }

//    /**
//     * @return SeanceExercice[] Returns an array of SeanceExercice objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SeanceExercice
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
