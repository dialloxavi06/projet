<?php

namespace App\Controller;

use App\Entity\Collaborateur;
use App\Form\AddCollaborateurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



class CollaborateurController extends AbstractController
{
    
   
    #[Route('/collaborateur', name: 'app_collaborateur')]
    public function index(ManagerRegistry $doctrine, Request $request, PaginatorInterface $paginator): Response
    {
        $em = $doctrine->getManager();
        $query = $em->getRepository(Collaborateur::class)->createQueryBuilder('p');

        $pagination = $paginator->paginate(
            $query->getQuery(),
            $request->query->getInt('page', 1), // Récupère le numéro de page de la requête, par défaut 1
            10 // Nombre d'éléments par page
        );

        return $this->render('collaborateur/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/add/{id?0}', name: 'collaborateur.add')]
    public function addCollaborateur(
        Collaborateur $collaborateur = null,
        ManagerRegistry $doctrine,
        Request $request,
        int $id = 0
    ): Response {
        $entityManager = $doctrine->getManager();
        $new = false;
    
        // Si $collaborateur est null, créez une nouvelle instance de Collaborateur
        if (!$collaborateur) {
            $new = true;
    
            // Si $id est spécifié dans l'URL, récupérez le collaborateur correspondant
            if ($id) {
                $collaborateur = $entityManager->getRepository(Collaborateur::class)->find($id);
    
                // Si le collaborateur n'est pas trouvé, redirigez vers la page d'ajout avec un message d'erreur
                if (!$collaborateur) {
                    $this->addFlash('error', 'Collaborateur non trouvé');
                    return $this->redirectToRoute('collaborateur.add');
                }
            } else {
                $collaborateur = new Collaborateur();
            }
        }
    
        // Création du formulaire
        $form = $this->createForm(AddCollaborateurType::class, $collaborateur);
    
        // Traitement de la requête
        $form->handleRequest($request);
    
        // Vérifie si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion de l'entité dans la base de données
            $entityManager->persist($collaborateur);
            $entityManager->flush();
    
            // Ajout d'un message de succès
            $message = $new ? "Le collaborateur a été ajouté avec succès." : "Le collaborateur a été mis à jour avec succès.";
            $this->addFlash('success', $message);
    
            // Redirection vers la liste des collaborateurs
            return $this->redirectToRoute('app_collaborateur');
        }
    
        // Affichage du formulaire avec les erreurs
        return $this->render('collaborateur/addCollaborateur.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/collaborateur/{id}/delete', name: 'collaborateur.delete')]
    public function delete(int $id, ManagerRegistry $doctrine): RedirectResponse
    {
        $entityManager = $doctrine->getManager();
    
        // Récupérer le collaborateur
        $collaborateur = $entityManager->getRepository(Collaborateur::class)->find($id);
    
        if (!$collaborateur) {
            throw new NotFoundHttpException('Collaborateur non trouvé.');
        }
    
        // Supprimer les références dans les Projets associés
        foreach ($collaborateur->getProjets() as $projet) {
            $entityManager->remove($projet); 
        }
    
        // Supprimer le collaborateur
        $entityManager->remove($collaborateur);
        $entityManager->flush();
    
        $this->addFlash('success', 'Le Collaborateur a été supprimé avec succès.');
    
        return $this->redirectToRoute('app_collaborateur');
    }
    

}
