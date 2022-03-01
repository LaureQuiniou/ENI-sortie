<?php

namespace App\Controller;


use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Form\SearchForm;
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
use Symfony\Component\Security\Core\User\UserInterface;

class SortieController extends AbstractController
{
    /*/**
     * @Route("/sortie", name="sortie_afficher")
     */
    /*
    public function afficherTableau(SortieRepository $sortieRepository): Response
    {
        $sorties=$sortieRepository->findSorties();
        return $this->render('sortie/afficher.html.twig', [
            "sorties"=>$sorties

        ]);
    }*/
    /**
     * @Route("/sortie", name="sortie_afficher")
     */
    public function list(Request $request, SortieRepository $sortieRepository, UserInterface $user): Response
    {
        //valeurs par défaut du formulaire de recherche
        $searchData = [
            'est_inscrit' => false,
            'pas_inscrit' => false,
            'est_organisateur' => false,
            'sorties_passees'=>false,
        ];
        $searchForm = $this->createForm(SearchForm::class, $searchData);
        $searchForm->handleRequest($request);
        $searchData = $searchForm->getData();

        $sorties=$sortieRepository->searchSortiesAvecFiltres($searchData, $user);

        return $this->render('sortie/afficher.html.twig', [
            'searchForm' => $searchForm->createView(),
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
    /**
     * @Route("/inscription/{id}", name="sortie_inscription", methods={"GET"})
     */
    public function inscriptionSortie(int $id, EntityManagerInterface $entityManager, SortieRepository $sortieRepository, ParticipantRepository $participantRepository, UserInterface $user): Response
    {
        $sortieEnCours=$sortieRepository->find($id); // Trouver la sortie actuelle en cherchant son id
       $participant=new Participant();
       $participant=$participantRepository->findOneBy(['email'=>$this->getUser()->getUserIdentifier()]);
        $sortieEnCours->addParticipant($participant); //trouver le user actuel -> ajouter le participant à la sortie

        //sauvegarde en BDD
        $entityManager->persist($sortieEnCours);
        $entityManager->flush();

        //message de confirmation qui s'affiche
        $this->addFlash('succes', 'Tu es bien inscrit !');

        //on réaffiche les sorties
        //valeurs par défaut du formulaire de recherche
        $searchData = [
            'est_inscrit' => false,
            'pas_inscrit' => false,
            'est_organisateur' => false,
            'sorties_passees'=>false,
        ];
        $searchForm = $this->createForm(SearchForm::class, $searchData);
        $sorties=$sortieRepository->searchSortiesAvecFiltres($searchData, $user);

        //on redirige
        return $this->render('sortie/afficher.html.twig', [
            'searchForm' => $searchForm->createView(),
            "sorties"=>$sorties
        ]);

    }

    /**
     * @Route("/desister/{id}", name="sortie_desister", methods={"GET"})
     */
    public function desisterSortie(int $id, EntityManagerInterface $entityManager, SortieRepository $sortieRepository, ParticipantRepository $participantRepository,UserInterface $user): Response
    {
        $sortieEnCours=$sortieRepository->find($id); // Trouver la sortie actuelle en cherchant son id
        $participant=new Participant();
        $participant=$participantRepository->findOneBy(['email'=>$this->getUser()->getUserIdentifier()]);
        dump($sortieEnCours);
        $sortieEnCours->removeParticipant($participant); //trouver le user actuel -> ajouter le participant à la sortie

        //sauvegarde en BDD
        $entityManager->persist($sortieEnCours);
        $entityManager->flush();

        //message de confirmation qui s'affiche
        $this->addFlash('succes', 'Tu ne participeras plus, dommage !');

        //on réaffiche les sorties
        //valeurs par défaut du formulaire de recherche
        $searchData = [
            'est_inscrit' => false,
            'pas_inscrit' => false,
            'est_organisateur' => false,
            'sorties_passees'=>false,
        ];
        $searchForm = $this->createForm(SearchForm::class, $searchData);
        $sorties=$sortieRepository->searchSortiesAvecFiltres($searchData, $user);

        //on redirige
        return $this->render('sortie/afficher.html.twig', [
            'searchForm' => $searchForm->createView(),
            "sorties"=>$sorties
        ]);
    }
}


