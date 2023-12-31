<?php

namespace App\Repository;

use App\Entity\Seance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Seance>
 *
 * @method Seance|null find($id, $lockMode = null, $lockVersion = null)
 * @method Seance|null findOneBy(array $criteria, array $orderBy = null)
 * @method Seance[]    findAll()
 * @method Seance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Seance::class);
    }

    public function findSeancesByCategorieMuscle($categoryId)
    {
        return $this->createQueryBuilder('s')  // Assuming Seance has a direct relationship to CategorieMuscle
            ->join('s.seanceExercices', 'se')
            ->join('se.exercice', 'ecm')
            ->join('ecm.CategorieMuscles', 'cm')
            ->where('cm.id = ?1')
            ->setParameter(1,$categoryId)
            ->getQuery()
            ->getResult();
    }

    public function findMostFavorisSeance()
    {
        return $this->createQueryBuilder('s')  // Assuming Seance has a direct relationship to CategorieMuscle
            ->join('s.favorisUsers', 'uf')  // Assuming 'seanceFavoris' is the property in Seance entity
            ->groupBy('s.id')
            ->orderBy('COUNT(uf.id)', 'DESC') // Use the correct alias for the join table (uf.id)
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }


//    /**
//     * @return Seance[] Returns an array of Seance objects
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

//    public function findOneBySomeField($value): ?Seance
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function seanceUtilisateur($user_id): array
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $qb->select('s')
            ->from('App\Entity\Seance', 's')
            ->where('s.user = ?1')
            ->setParameter(1,$user_id);

        // renvoyer le résultat
        $query = $qb->getQuery();
        return $query->getResult();
    }
}
