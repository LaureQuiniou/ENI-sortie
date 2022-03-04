<?php

namespace App\Controller;


use App\Form\AnnulationForm;
use App\Form\SearchForm;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AnnulerSortieController extends AbstractController
{

    /**
     * @Route ("/annulerSortie/{id}", name="sortie_annuler")
     */
    public function annulerSortie(int $id, SortieRepository $sortieRepository,Request $request, EntityManagerInterface $entityManager): Response
    {
        $sortieChoisie=$sortieRepository->find($id);
        $annulationForm = $this->createForm(AnnulationForm::class, $sortieChoisie);

        $annulationForm->handleRequest($request);

        if ($annulationForm->isSubmitted() && $annulationForm->isValid()){
            $entityManager->persist($sortieChoisie);
            $entityManager->flush();

            $this->addFlash('success', 'Vous avez bien annulé la sortie');
            return $this->redirectToRoute('sorties_afficher');
        }

        return $this->render('sortie/annulerSortie.html.twig', [
            'sortieChoisie'=>$sortieChoisie,
            'annulationForm'=>$annulationForm->createView()
        ]);
    }
}
