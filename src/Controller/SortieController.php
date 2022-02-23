<?php

namespace App\Controller;

use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    /**
     * @Route("/sortie", name="sortie_afficher")
     */
    public function afficher(SortieRepository $sortieRepository): Response
    {
        $sorties=$sortieRepository->findAll();
        return $this->render('sortie/afficher.html.twig', [
            "sorties"=>$sorties

        ]);
    }
}
