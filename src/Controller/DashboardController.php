<?php

namespace App\Controller;

use App\Entity\Projet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;



class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        // Indicateurs : Nombre d'entités principales par 'status'
        $statusCounts = $entityManager->getRepository(Projet::class)->getStatusCounts();

        // Les 5 dernières entités principales
        $latestEntities = $entityManager->getRepository(Projet::class)->findLatestEntities(5);

        // Le taux de chaque 'status'
        $statusRates = $entityManager->getRepository(Projet::class)->getStatusRates();

        return $this->render('dashboard/index.html.twig', [
            'statusCounts' => $statusCounts,
            'latestEntities' => $latestEntities,
            'statusRates' => $statusRates,
        ]);
    }
}
