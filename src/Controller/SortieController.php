<?php

namespace App\Controller;


use App\Entity\Participant;
use App\Entity\Sortie;
use App\Form\SortieType;
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
}


