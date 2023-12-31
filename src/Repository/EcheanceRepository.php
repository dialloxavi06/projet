<?php

namespace App\Repository;

use App\Entity\Echeance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Echeance>
 *
 * @method Echeance|null find($id, $lockMode = null, $lockVersion = null)
 * @method Echeance|null findOneBy(array $criteria, array $orderBy = null)
 * @method Echeance[]    findAll()
 * @method Echeance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EcheanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Echeance::class);
    }

//    /**
//     * @return Echeance[] Returns an array of Echeance objects
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

//    public function findOneBySomeField($value): ?Echeance
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
