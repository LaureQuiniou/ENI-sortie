<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ProfilType;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ProfilController extends AbstractController
{
    /**
     * @Route("/monProfil", name="mon_profil")
     */
    public function AfficherProfilUser(): Response
    {

        return $this->render('profil/AfficherProfilUser.html.twig');
    }

    /**
     * @Route ("/profilParticipant/{id}", name="profil_participant", methods={"GET"})
     */
    public function AfficherProfilParticipant(int $id, ParticipantRepository $participantRepository): Response
    {
        $profilParticipant= $participantRepository->find($id);

        // si l'utilisateur n'existe pas en bdd, on déclenche une erreur 404
        if(!$profilParticipant)
        {
            throw $this->createNotFoundException("Cet utilisateur n'existe pas...");
        }

        return $this->render('profil/afficherProfil.html.twig', [
            'participant' => $profilParticipant
        ]);
    }

    /**
     * @Route("/monProfil/modifier", name="profil_modifier")
     */
    public function ModifierProfil(UserInterface $user,Request $request, EntityManagerInterface $entityManager, ParticipantRepository $participantRepository): Response
    {
        //$participant = $this->getUser();
        $profilForm = $this->createForm(ProfilType::class, $user);
        $profilForm->handleRequest($request);

            if($profilForm->isSubmitted() && $profilForm->isValid()){

                // vérification si mot de passe est à changer (si champs newPassword pas null et pas vide)
                if(!$request->request->get('newPassword') && $request->request->get('newPassword')!=''){
                    $user->setPassword($request->request->get('newPassword'));
                }

                $entityManager->persist($user);
                $entityManager->flush();
                $this->addFlash('success','Vos modifications ont bien été prises en compte');
                return $this->redirectToRoute('mon_profil');
            }

      return $this->render('profil/modifierProfil.html.twig',[
          'profilForm' => $profilForm->createView()
        ]);
    }
}
