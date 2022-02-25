<?php

namespace App\Controller;

use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AfficherUneSortieController extends AbstractController
{
    /**
     * @Route ("/afficherSortie/{id}", name="afficher_une_sortie", methods={"GET"})
     */
    public function afficherUneSortie(int $id, SortieRepository $sortieRepository): Response
    {
        // récupère la sortie en fonction de l'ID présent dans l'URL
        $sortie = $sortieRepository->find($id);

        // si elle n'existe pas en bdd, on déclenche une erreur 404
        if(!$sortie)
        {
            throw $this->createNotFoundException('Cette sortie n existe pas...');
        }
        return $this->render('afficher_une_sortie/afficherSortie.html.twig', [
            'sortie' => $sortie
        ]);
    }
}
