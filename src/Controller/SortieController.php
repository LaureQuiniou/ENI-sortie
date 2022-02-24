<?php

namespace App\Controller;


use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Form\SortieType;
use App\Repository\EtatRepository;
use App\Repository\LieuRepository;
use App\Repository\ParticipantRepository;
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
    public function afficherTableau(SortieRepository $sortieRepository): Response
    {
        $sorties=$sortieRepository->findSorties();
        return $this->render('sortie/afficher.html.twig', [
            "sorties"=>$sorties

        ]);
    }

    /**
     * @Route("/cree_une_sortie", name="sortie_creer")
     */
    public function creerSortie(Request $request, EntityManagerInterface $entityManager, EtatRepository $etatRepository, LieuRepository $lieuRepository, ParticipantRepository $participantRepository): Response
    {
        $sortie = new Sortie();
        $organisateur = $participantRepository->findOneBy(['email'=>$this->getUser()->getUserIdentifier()]);
        $sortieForm = $this->createForm(SortieType::class, $sortie);
        $sortieForm->handleRequest($request);

        if ($sortieForm->isSubmitted() && $sortieForm->isValid()){
            $lieu = $lieuRepository->findOneBy(['nom'=>'Le chat Noir']);
            $sortie->setCampus($this->getUser()->getCampus());
            $sortie->setOrganisateur($organisateur);
            $etat = $etatRepository->findOneBy(['libelle'=>'ouverte']);
            $sortie->setEtat($etat);
            $sortie->setLieu($lieu);
            $entityManager->persist($sortie);
            $entityManager->flush();
        }

        return $this->render('sortie/creer_une_sortie.html.twig', [
                'sortieForm' => $sortieForm->createView()
        ]);
    }
}
