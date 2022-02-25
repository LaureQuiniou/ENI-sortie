<?php

namespace App\Controller;

use App\Form\SortieType;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModifierSortieController extends AbstractController
{

    /**
     * @Route("/modifierSortie/{id}",name="modifier_sortie", methods={"GET"})
     */
    public function modifierSortie(int $id, EntityManagerInterface $entityManager, Request $request,SortieRepository $sortieRepository): Response
    {
        //récupère cette sortie
        $sortieEnCours=$sortieRepository->find($id); // Trouver la sortie actuelle en cherchant son id
        $sortieForm = $this->createForm(SortieType::class, $sortieEnCours);
        $sortieForm->handleRequest($request);

        if($sortieForm->isSubmitted() && $sortieForm->isValid())
        {
            $entityManager->persist($sortieEnCours);
            $entityManager->flush();
            $this->addFlash('success','Ta sortie a été modifiée avec succès ! ');
            return $this->redirectToRoute('sortie_afficher');
        }

        //Redirige
        return $this->render('modifier_sortie/modifSortie.html.twig', [
            'sortieForm'=>$sortieForm->createView()
        ]);
    }

}
