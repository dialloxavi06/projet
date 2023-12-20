<?php

namespace App\Repository;

use App\Entity\Projet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Projet>
 *
 * @method Projet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Projet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Projet[]    findAll()
 * @method Projet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Projet::class);
    }

//    /**
//     * @return Projet[] Returns an array of Projet objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Projet
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }




public function getStatusCounts()
{
  
    $queryBuilder = $this->createQueryBuilder('e')
        ->select('e.status, COUNT(e.id) as entityCount')
        ->groupBy('e.status');

    $result = $queryBuilder->getQuery()->getResult();

    $statusCounts = [];

    foreach ($result as $row) {
        if (
            isset($row['status']) &&
            isset($row['entityCount']) &&
            $row['status'] instanceof \App\Enum\StatutTâche // Vérifiez le type d'énumération
        ) {
            // Exemple hypothétique : suppose que la valeur est accessible via une propriété publique
            $status = $row['status']->value; // Utilisez la propriété publique (changez "value" selon votre énumération)
            $count = $row['entityCount'];

            $statusCounts[$status] = $count;
        }
    }

    return $statusCounts;

}

public function findLatestEntities($limit)
{
    // Écrire votre logique pour récupérer les 5 dernières entités

    return $this->createQueryBuilder('e')
    ->orderBy('e.createdAt', 'DESC') // Suppose que votre entité a une propriété createdAt
    ->setMaxResults($limit)
    ->getQuery()
    ->getResult();
}
public function getStatusRates()
{
    // Récupérer le nombre total d'entités principales
    $totalEntities = $this->createQueryBuilder('e')
        ->select('COUNT(e.id)')
        ->getQuery()
        ->getSingleScalarResult();

    // Récupérer le nombre d'entités principales par 'status'
    $statusCounts = $this->createQueryBuilder('e')
        ->select('e.status, COUNT(e.id) as entityCount')
        ->groupBy('e.status')
        ->getQuery()
        ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

   

    // Calculer le taux de chaque 'status'
    $statusRates = [];
    
    foreach ($statusCounts as $row) {
        if (
            isset($row['status']) &&
            isset($row['entityCount']) &&
            $row['status'] instanceof \App\Enum\StatutTâche
        ) {
            $status = $row['status']->value; // Remplacez "value" par le nom de la propriété réelle
            $count = $row['entityCount'];

            // Éviter la division par zéro
            $statusRates[$status] = $totalEntities > 0 ? ($count / $totalEntities) * 100 : 0;
        }
    }

    return $statusRates;
}

}
