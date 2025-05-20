<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\ListeJeuxForm;
use App\Entity\Jeu;
use App\Entity\Partie;
use App\Entity\Score;
use App\Form\ScoreForm;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

final class TopScoresController extends AbstractController
{
    #[Route('/topscores/{id}', name: 'app_top_scores')]
    public function index(Request $request, $id, EntityManagerInterface $entityManager): Response
    {
        $jeu = $entityManager->getRepository(Jeu::class)->find($id);
        $formListJeu = $this->createForm(ListeJeuxForm::class);
        $formListJeu->handleRequest($request);

        if ($formListJeu->isSubmitted() && $formListJeu->isValid()) {
            $jeu = $formListJeu->get('Jeu')->getData();
            return $this->redirectToRoute('app_top_scores', ['id' => $jeu->getId()]);
        }

        // Correction ici: utiliser soit le nom correct de la propriété de relation (probablement 'jeu' en minuscule)
        // ou utiliser DQL si la relation est complexe
        $scores = $entityManager->getRepository(Partie::class)->findBy(['jeu' => $jeu]);

        // Alternative avec DQL si nécessaire:
        // $query = $entityManager->createQuery(
        //     'SELECT p FROM App\Entity\Partie p WHERE p.jeu = :jeu'
        // )->setParameter('jeu', $jeu);
        // $scores = $query->getResult();

        // Trier les scores par ordre décroissan
        usort($scores, function ($a, $b) {
            return $b->getScore() <=> $a->getScore();
        });

        // Garder uniquement du mois en cours
        $scores = array_filter($scores, function ($score) {
            $date = new \DateTime();
            $date->modify('first day of this month');
            $date->setTime(0, 0, 0);
            $date2 = new \DateTime();
            $date2->setTime(23, 59, 59);
            return $score->getDate() >= $date && $score->getDate() <= $date2;
        });

        return $this->render('top_scores/index.html.twig', [
            'formListJeu' => $formListJeu->createView(),
            'jeu' => $jeu,
            'topscores' => $scores,
        ]);
    }
}