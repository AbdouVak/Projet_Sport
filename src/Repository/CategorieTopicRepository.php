<?php

namespace App\Repository;

use App\Entity\CategorieTopic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategorieTopic>
 *
 * @method CategorieTopic|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieTopic|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieTopic[]    findAll()
 * @method CategorieTopic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieTopicRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieTopic::class);
    }

    public function findMostPopularTopics()
    {
        return $this->createQueryBuilder('ct')
            ->leftJoin('ct.topics', 't')
            ->groupBy('ct.id')
            ->orderBy('COUNT(t.id)', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }


//    /**
//     * @return CategorieTopic[] Returns an array of CategorieTopic objects
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

//    public function findOneBySomeField($value): ?CategorieTopic
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
