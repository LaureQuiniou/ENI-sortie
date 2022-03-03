<?php

namespace App\Controller;


use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Entity\Ville;
use App\Form\LieuType;
use App\Form\SearchForm;
use App\Form\SortieType;
use App\Repository\EtatRepository;
use App\Repository\LieuRepository;


use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;

use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @Route("/sortie", name="sorties_afficher")
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
    public function creerSortie(Request $request, EntityManagerInterface $entityManager, VilleRepository $villeRepository,
                                LieuRepository $lieuRepository,ParticipantRepository $participantRepository, EtatRepository $etatRepository): Response
    {   $sortieEnCours=new Sortie();
        $li= new Lieu();
        $ville = new Ville;
        $li->setVille($ville);
        $sortieEnCours->setLieu($li);
        $sortie = new Sortie();
        $lieux=[];
        $organisateur = $participantRepository->findOneBy(['email'=>$this->getUser()->getUserIdentifier()]);
        $villes=[];

        //récuppère info dans le cas de modifier sortie
        if(($request->get('sortieEnCours'))) {
            $sortieEnCours = $request->get('sortieEnCours');
            //$sortie=clone $sortieEnCours;
        }

        //création du formulaire
        $sortieForm = $this->createForm(SortieType::class, $sortie);
        $sortieForm->handleRequest($request);

        //Traitement des requets Ajax
        if($request->get('ajax')){
            if(!empty($request->get('ville'))) {
                if (!empty($request->get('lieu'))) {
                    $villee = $request->get('ville');
                    $lieu = $request->get('lieu');
                    if ($lieu == 1) {
                        $lieu = '';
                    }
                    $lieux = $lieuRepository->findLieux($villee, $lieu);
                    return new JsonResponse(['content' => $this->renderView('sortie/inc/_formulairePartieLieu.html.twig', ['lieux' => $lieux])]);
                } else {
                    $data = $request->get('ville');
                    $villes = $villeRepository->findVille($data);
                    return new JsonResponse(['content' => $this->renderView('sortie/inc/_formulairePartieVille.html.twig', ['villes' => $villes])]);
                }
            }elseif (!empty($request->get('lieu'))){
                    $lieu=$lieuRepository->findOneBy(["nom"=>$request->get('lieu')]);
                    $sortieEnCours->setLieu($lieu);
                    return new JsonResponse(['content'=> $this->renderView('sortie/inc/_formulairePartieRue.html.twig', ['sortieForm'=>$sortieForm->createView(),'sortieEnCours'=>$sortieEnCours])]);
            }
        }

        //Traitement des données
        if ($sortieForm->isSubmitted() && $sortieForm->isValid()){
            $villess= explode(' ',$sortieForm['lieu']['ville']->getdata());
            $ville= $villeRepository->findBy(['nom'=>$villess[1]]);
            $lieu = $lieuRepository->findOneBy(['ville'=>$ville,'nom'=>$sortieForm['lieu']['nom']->getdata()]);
            $sortie->setCampus($this->getUser()->getCampus());
            $sortie->setOrganisateur($organisateur);
            if(!empty($request->request->get('publier') )){
                $etat = $etatRepository->findOneBy(['libelle' => 'Ouverte']);
                $sortie->setEtat($etat);
                $this->addFlash('success', 'Votre sortie a bien été publiée!!');
            }elseif(!empty($request->request->get('enregistrer'))){
                $etat = $etatRepository->findOneBy(['libelle' => 'Création']);
                $sortie->setEtat($etat);
                $this->addFlash('success', 'Votre sortie a bien été enregistrée !!');
            }
            $sortie->setLieu($lieu);
            $entityManager->persist($sortie);
            $entityManager->flush();


            return $this->redirectToRoute('sorties_afficher');
        }


        return $this->render('sortie/creer_une_sortie.html.twig', [
                'sortieForm' => $sortieForm->createView(),'villes' => $villes, 'lieux' => $lieux, 'lieu' => $li, 'sortieEnCours'=>$sortieEnCours
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


