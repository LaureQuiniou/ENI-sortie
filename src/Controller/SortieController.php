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
use App\Repository\WishRepository;
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
    /**
     * @Route("/inscription/{id}", name="sortie_inscription", methods={"GET"})
     */
    public function inscriptionSortie(int $id, EntityManagerInterface $entityManager, SortieRepository $sortieRepository, ParticipantRepository $participantRepository): Response
    {
        $sortieEnCours=$sortieRepository->find($id); // Trouver la sortie actuelle en cherchant son id
        $participant=new Participant();
        $participant=$participantRepository->findOneBy(['email'=>$this->getUser()->getUserIdentifier()]);
        dump($sortieEnCours);
        $sortieEnCours->addParticipant($participant); //trouver le user actuel -> ajouter le participant à la sortie

        //sauvegarde en BDD
        $entityManager->persist($sortieEnCours);
        $entityManager->flush();

        //message de confirmation qui s'affiche
        $this->addFlash('succes', 'Tu es bien inscrit !');

        //on réaffiche les sorties
        $sorties=$sortieRepository->findSorties();

        //on redirige
        return $this->render('sortie/afficher.html.twig', [
            "sorties"=>$sorties,
            //Je rajoute ca???  'id'=>$id->getId()

        ]);
    }

    /**
     * @Route("/desister/{id}", name="sortie_desister", methods={"GET"})
     */
    public function desisterSortie(int $id, EntityManagerInterface $entityManager, SortieRepository $sortieRepository, ParticipantRepository $participantRepository): Response
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
        $sorties=$sortieRepository->findSorties();

        //on redirige
        return $this->render('sortie/afficher.html.twig', [
            "sorties"=>$sorties,
            //Je rajoute ca???  'id'=>$id->getId()

        ]);
    }

    /**
     * @Route ("/afficherSortie", name="afficher_sortie")
     */
    public function afficherSortie(): Response
    {
        return $this->render('afficherSortie.html.twig');
    }


    /**
     * @Route ("/modifierSortie", name="modifier_sortie")
     */
    public function modifierSortie(): Response
    {
        return $this->render('modifierSortie.html.twig');
    }


    /**
     * @Route ("/annulerSortie", name="annuler_sortie")
     */
    public function annulerSortie(): Response
    {
        return $this->render('annulerSortie.html.twig');
    }
}


