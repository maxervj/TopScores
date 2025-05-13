<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\ListeJeuxForm;
use App\Entity\Jeu;
use Doctrine\ORM\EntityManager;

final class TopScoresController extends AbstractController
{
    #[Route('topscores/{id}', name: 'app_top_scores')]
    public function index(Request $request, $id, EntityManager $entity_Manager): Response
    {
        $Jeu = $entity_Manager->getRepository(Jeu::class)->find($id);
        $formListJeu = $this->createForm(ListeJeuxForm::class);
        $formListJeu->handleRequest($request);

        if( $formListJeu->isSubmitted() && $formListJeu->isValid()) {
            $Jeu = $formListJeu->get('jeux')->getData();
            return $this->redirectToRoute('app_top_scores', ['id' => $Jeu->getId()]);

            

           
        }
        

             return $this->render('top_scores/index.html.twig', [
            'formListJeu' => $formListJeu,
       
        ]);

    }
}
