<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Event\AddProjetEvent;
use App\Form\ProjetType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class ProjetController extends AbstractController
{

    public function __construct(
        private EventDispatcherInterface $dispatcher
    )
    {
        
    }

  /**
   * display all project
   *
   * @param ManagerRegistry $doctrine
   * @param Request $request
   * @param PaginatorInterface $paginator
   * @return Response
   */
    #[Route('/projet', name: 'app_projet')]
    public function index(ManagerRegistry $doctrine, Request $request, PaginatorInterface $paginator): Response
    {
        $em = $doctrine->getManager();
        $query = $em->getRepository(Projet::class)->createQueryBuilder('p');

        $pagination = $paginator->paginate(
            $query->getQuery(),
            $request->query->getInt('page', 1), // Récupère le numéro de page de la requête, par défaut 1
            10 // Nombre d'éléments par page
        );

        return $this->render('projet/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/projet/{id}', name: 'app_projet_detail')]
    public function show(Projet $projet): Response
    {
        return $this->render('projet/detail.html.twig', [
            'projet' => $projet,
        ]);
    }

     /**
 * Supprimer un projet.
 *
 * 
 */


    #[Route('/projet/{id}/delete', name: 'app_projet_delete')]
    public function delete(int $id, ManagerRegistry $doctrine): RedirectResponse
    {
        $entityManager = $doctrine->getManager();
        
        // Récupère l'objet Projet à partir de l'ID
        $projet = $entityManager->getRepository(Projet::class)->find($id);

        // Vérifie si le projet existe
        if (!$projet) {
            throw new NotFoundHttpException('Projet non trouvé.');
        }

        // Supprime le projet
        $entityManager->remove($projet);
        $entityManager->flush();

        $this->addFlash('success', 'Le projet a été supprimé avec succès.');

        return $this->redirectToRoute('app_projet');
    }

 /**
 * Ajout d'un projet.
 *
 * @Route('/edit/{id?0}', name='projet.add')
 */
#[Route('/edit/{id?0}', name: 'projet.add')]

public function addProjet
(
    Projet $projet = null,
    ManagerRegistry $doctrine,
    Request $request,
    int $id = 0 // Ajout du paramètre $id pour récupérer l'identifiant du projet
): Response 
{
    $entityManager = $doctrine->getManager();
    $new = false;

    // Si $projet est null, créez une nouvelle instance de Projet
    if (!$projet) {
        $new = true;
        
        // Si $id est spécifié dans l'URL, récupérez le projet correspondant
        if ($id) {
            $projet = $entityManager->getRepository(Projet::class)->find($id);

            // Si le projet n'est pas trouvé, redirigez vers la page d'ajout avec un message d'erreur
            if (!$projet) {
                $this->addFlash('error', 'Projet non trouvé');
                return $this->redirectToRoute('projet.add');
            }
        } else {
            $projet = new Projet();
        }
    }

    // Création du formulaire
    $form = $this->createForm(ProjetType::class, $projet);

    // Traitement de la requête
    $form->handleRequest($request);

    // Vérifie si le formulaire a été soumis et est valide
    if ($form->isSubmitted() && $form->isValid()) {
        // Gestion de l'entité dans la base de données
        $entityManager->persist($projet);
        $entityManager->flush();

        // Ajout d'un message de succès
        $message = $new ? " a été ajouté avec succès" : " a été mis à jour avec succès";
        $this->addFlash('success', $projet->getName() . $message);

        if($new){
            //on a crée notre Evenement
            $addProjetEvent = new AddProjetEvent($projet);
            // on va maintenant dispatcher notre evenement
            $this->dispatcher->dispatch($addProjetEvent, AddProjetEvent::ADD_PROJET_EVENT);
        }
        dump($addProjetEvent);

        // Redirection vers la liste des projets
        return $this->redirectToRoute('app_projet');
    }

    // Affichage du formulaire avec les erreurs
    return $this->render('projet/add.html.twig', [
        'form' => $form->createView(),
    ]);
}

}
