<?php

namespace App\Controller;


use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PersonneController extends AbstractController
{

    public function __construct(
        
    )
    {}

    #[Route('/personne', name: 'personne.list')]
    public function index(ManagerRegistry $doctrine): Response {
        $repository = $doctrine->getRepository(User::class);
        $personnes = $repository->findAll();
        return $this->render('personne/index.html.twig',
         [
            'users' => $personnes
        ]);
    }


    
   
    }
    

