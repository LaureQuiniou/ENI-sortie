<?php

namespace App\Controller;


use App\Repository\SortieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AnnulerSortieController extends AbstractController
{

    /**
     * @Route ("/annulerSortie/{id}", name="annuler_sortie", methods={"GET"})
     */
    public function annulerSortie(int $id, SortieRepository $sortieRepository): Response
    {
        $sorties=$sortieRepository->find($id);

        return $this->render('annuler_sortie/annulerSortie.html.twig', [
            "sorties"=>$sorties

        ]);
    }
}
