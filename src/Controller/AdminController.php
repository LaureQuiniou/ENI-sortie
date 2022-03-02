<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\RegistrationFormType;
use App\Repository\ParticipantRepository;
use App\Security\AppAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/gestionUtilisateurs", name="admin_gestionUtilisateurs")
     * @IsGranted("ROLE_ADMIN")
     */
    public function ListerUtilisateurs(ParticipantRepository $participantRepository): Response
    {
        $utilisateurs = $participantRepository->findAll();
        return $this->render('admin/gestion_administrateur.html.twig', [
            'utilisateurs'=>$utilisateurs
        ]);
    }

    /**
     * @Route("/admin/register", name="admin_register")
     * @IsGranted("ROLE_ADMIN")
     */
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, AppAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new Participant();
        $user->setActif(true);
        $user->setRoles(['ROLE_USER']);
        $user->setSuppression(false);
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute("admin_gestionUtilisateurs");
        }
        return $this->render('admin/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
    * @Route("/admin/supprimerUtilisateur/{id}", name="admin_supprimerUtilisateur")
     * @IsGranted("ROLE_ADMIN")
    */
    public function supprimerUtilisateur(Participant $participant, EntityManagerInterface $entityManager){

        if (!$participant->getSuppression()){
            $participant->setSuppression(true);
        }
        $entityManager->persist($participant);
        $entityManager->flush();

        $this->addFlash('success', "L'utilisateur ".$participant->getPrenom()." ".$participant->getNom()." a bien été supprimé !");
        return $this->redirectToRoute('admin_gestionUtilisateurs');
    }

    /**
    * @Route("/admin/desactiverUtilisateur/{id}", name="admin_desactiverUtilisateur")
     * @IsGranted("ROLE_ADMIN")
    */
   public function desactiverUtilisateur(Participant $participant, EntityManagerInterface $entityManager){

       if ($participant->getActif()){
           $participant->setActif(false);
       }else{
           $participant->setActif(true);
       }
       $entityManager->persist($participant);
       $entityManager->flush();

       $activite=$participant->getActif()? "activé(e)":"désactivé(e)";
       $this->addFlash('success', "L'utilisateur ".$participant->getPrenom()." ".$participant->getNom()." a bien été $activite !");
        return $this->redirectToRoute('admin_gestionUtilisateurs');
   }

}