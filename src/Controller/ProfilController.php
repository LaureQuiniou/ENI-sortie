<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ProfilType;
use App\Repository\ParticipantRepository;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     */
    public function AfficherProfil(ParticipantRepository $participantRepository): Response
    {

        return $this->render('profil/profil.html.twig');
    }

    /**
     * @Route("/profil/modifier", name="profil_modifier")
     */
    public function ModifierProfil(Request $request, EntityManagerInterface $entityManager): Response
    {
        $participant = new Participant();
        $profilForm = $this->createForm(ProfilType::class, $participant);
       $profilForm->handleRequest($request);

            if($profilForm->isSubmitted() && $profilForm->isValid()){
                $entityManager->persist($participant);
                $entityManager->flush();
                return $this->redirectToRoute('/profil');
            }

      return $this->render('profil/modifierProfil.html.twig',[
          'profilForm' => $profilForm->createView()
        ]);
    }
}
