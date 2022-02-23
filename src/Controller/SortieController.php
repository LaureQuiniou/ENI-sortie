<?php

namespace App\Controller;


use App\Entity\Sortie;
use App\Form\SortieType;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/cree_une_sortie", name="sortie_creer")
     */
    public function creerSortie(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sortie = new Sortie();
        $sortieForm = $this->createForm(SortieType::class, $sortie);

        $sortieForm->handleRequest($request);

        if ($sortieForm->isSubmitted() && $sortieForm->isValid()){
            $entityManager->persist($sortie);
            $entityManager->flush();
        }

        return $this->render('sortie/creer_une_sortie.html.twig', [
                'sortieForm' => $sortieForm->createView()
        ]);
    }
}
