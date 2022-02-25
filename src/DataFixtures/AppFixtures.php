<?php

//      php bin/console doctrine:fixtures:load


namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\DBAL\Types\TimeType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\Time;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Campus
        $quinper = new Campus();
        $quinper->setNom('Quimper');
        $stHerblain = new Campus();
        $stHerblain -> setNom('Saint-Herblain');
        $chartres = new Campus();
        $chartres ->setNom('Chartres-de-Bretagne');
        $roche = new Campus();
        $roche -> setNom('La Roche-Sur-Yon');
        $manager->persist($quinper);
        $manager->persist($stHerblain);
        $manager->persist($chartres);
        $manager->persist($roche);


        // Villes
        $villeQuimper = new Ville();
        $villeRoche = new Ville();
        $villeStHerblain = new Ville();
        $villeNantes = new Ville();
        $villeQuimper->setNom('QUIMPER');
        $villeRoche->setNom('La-ROCHE-SUR-YON');
        $villeNantes->setNom('NANTES');
        $villeStHerblain->setNom('SAINT-HERBLAIN');
        $villeQuimper->setCodePostal('29000');
        $villeRoche->setCodePostal('85000');
        $villeNantes->setCodePostal('44000');
        $villeStHerblain->setCodePostal('44162');
        $manager->persist($villeNantes);
        $manager->persist($villeRoche);
        $manager->persist($villeStHerblain);
        $manager->persist($villeQuimper);

        // Lieu
        $chat = new Lieu();
        $chat->setNom('Le chat Noir');
        $chat->setRue('13 All Duguay Trouin');
        $chat->setVille($villeQuimper);
        $quai = new Lieu();
        $quai->setNom('OK quais bar');
        $quai->setRue('2 Rue de Pont l\'Abbé');
        $quai->setVille($villeStHerblain);
        $bow = new Lieu();
        $bow->setNom('BowlCenter');
        $bow->setRue('24 Rue de l\'église');
        $bow->setVille($villeRoche);
        $pat = new Lieu();
        $pat->setNom('Patinoire');
        $pat->setRue('2 Rue de l\'Olympe');
        $pat->setVille($villeNantes);
        $manager->persist($chat);
        $manager->persist($quai);
        $manager->persist($bow);
        $manager->persist($pat);

        // Etat
        $creation= new Etat();
        $creation->setLibelle('Création');
        $ouverte = new Etat();
        $ouverte->setLibelle('Ouverte');
        $clot = new Etat();
        $clot->setLibelle('Clôturée');
        $enCours = new Etat();
        $enCours->setLibelle('Activité en cours');
        $passee = new Etat();
        $passee->setLibelle('Passée');
        $annulee = new Etat();
        $annulee->setLibelle('Annulée');
        $manager->persist($creation);
        $manager->persist($ouverte);
        $manager->persist($clot);
        $manager->persist($enCours);
        $manager->persist($passee);
        $manager->persist($annulee);

        // Participants
        $user1 = new Participant();
        $user2 = new Participant();
        $user3 = new Participant();
        $user4 = new Participant();
        $user1->setNom('Dupond');
        $user1->setPrenom('Bernard');
        $user1->setEmail('admin@eni.com');
        $user1->setRoles(["ROLE_ADMIN"]);
        $user1->setPassword('$2y$13$6Iwj4bq8eWGgYEu8OPfn6uZkCm6YZcph45u9MsJTR3QnStIZ8xRdy');
        $user1->setPseudo('adminou');
        $user1->setTelephone('01.35.45.78.65');
        $user1->setActif(true);
        $user1->setCampus($chartres);
        $user2->setNom('Duprès');
        $user2->setPrenom('Natalie');
        $user2->setEmail('user@eni.com');
        $user2->setRoles(["ROLE_USER"]);
        $user2->setPassword('$2y$13$6Iwj4bq8eWGgYEu8OPfn6uZkCm6YZcph45u9MsJTR3QnStIZ8xRdy');
        $user2->setPseudo('userinou');
        $user2->setTelephone('05.45.78.36.67');
        $user2->setActif(true);
        $user2->setCampus($stHerblain);
        $user3->setNom('Le Kerguerec');
        $user3->setPrenom('Yohann');
        $user3->setEmail('organisateur@eni.com');
        $user3->setRoles(["ROLE_USER"]);
        $user3->setPassword('$2y$13$6Iwj4bq8eWGgYEu8OPfn6uZkCm6YZcph45u9MsJTR3QnStIZ8xRdy');
        $user3->setPseudo('organinou');
        $user3->setTelephone('07.32.98.54.22');
        $user3->setActif(true);
        $user3->setCampus($quinper);
        $user4->setNom('Marteau');
        $user4->setPrenom('Pierre');
        $user4->setEmail('participant@eni.com');
        $user4->setRoles(["ROLE_USER"]);
        $user4->setPassword('$2y$13$6Iwj4bq8eWGgYEu8OPfn6uZkCm6YZcph45u9MsJTR3QnStIZ8xRdy');
        $user4->setPseudo('participinou');
        $user4->setTelephone('02.55.84.10.74');
        $user4->setActif(true);
        $user4->setCampus($roche);
        $manager->persist($user1);
        $manager->persist($user2);
        $manager->persist($user3);
        $manager->persist($user4);

        //Sorties
        $sortie1 = new Sortie();
        $sortie2 = new Sortie();
        $sortie3 = new Sortie();
        $sortie4 = new Sortie();
        $sortie5 = new Sortie();
        $sortie6 = new Sortie();
        $sortie7 = new Sortie();
        $sortie8 = new Sortie();

        $sortie1->setCampus($roche);
        $sortie1->setNom('Allez boire un verre');
        $sortie1->setInfosSortie('Rendez-vous à 19h au ok quais bar. Pour ceux qui le souhaite nous pourrons ensuite allez manger ensemble :)!');
        $sortie1->setLieu($quai);
        $sortie1->setDateHeureDebut(new \DateTime('2022-02-24 19:00:00'));
        $sortie1->setDateLimiteInscription(new \DateTime('2022-02-23 19:00:00'));
        $sortie1->setDuree(new \DateTime('02:00:00'));
        $sortie1->setOrganisateur($user3);
        $sortie1->setEtat($ouverte);
        $sortie1->setNbInscriptionsMax(10);
        $sortie1->addParticipant($user2);
        $sortie1->addParticipant($user1);
        $sortie1->addParticipant($user4);

        $sortie2->setCampus($stHerblain);
        $sortie2->setNom('Un resto ca vous dit?');
        $sortie2->setInfosSortie('Un petit resto pour faire connaissance! Les anciens et les nouveaux de l\'ENI sont les bienvenus!');
        $sortie2->setLieu($chat);
        $sortie2->setDateHeureDebut(new \DateTime('2022-03-01 12:00:00'));
        $sortie2->setDateLimiteInscription(new \DateTime('2022-02-28 22:00:00'));
        $sortie2->setDuree(new \DateTime('02:00:00'));
        $sortie2->setOrganisateur($user2);
        $sortie2->setEtat($ouverte);
        $sortie2->setNbInscriptionsMax(6);
        $sortie2->addParticipant($user3);

        $sortie3->setCampus($chartres);
        $sortie3->setNom('Rencontre à la patinoire de la Roche');
        $sortie3->setInfosSortie('Glissade à la patinoire de la Roche sur Yon. Rendez-vous à 14h devant la patinoire!');
        $sortie3->setLieu($pat);
        $sortie3->setDateHeureDebut(new \DateTime('2022-02-26 14:00:00'));
        $sortie3->setDateLimiteInscription(new \DateTime('2022-02-25 22:00:00'));
        $sortie3->setDuree(new \DateTime('04:00:00'));
        $sortie3->setOrganisateur($user2);
        $sortie3->setEtat($ouverte);
        $sortie3->setNbInscriptionsMax(15);
        $sortie3->addParticipant($user1);
        $sortie3->addParticipant($user4);

        $sortie4->setCampus($roche);
        $sortie4->setNom('Rencontre au OK Quais Bar');
        $sortie4->setInfosSortie('Rendez-vous à 19h au ok quais bar. Comme la dernière fois un resto est prévu pour ceux qui le souhaiteront!');
        $sortie4->setLieu($quai);
        $sortie4->setDateHeureDebut(new \DateTime('2022-03-05 19:00:00'));
        $sortie4->setDateLimiteInscription(new \DateTime('2022-03-04 19:00:00'));
        $sortie4->setDuree(new \DateTime('03:00:00'));
        $sortie4->setOrganisateur($user3);
        $sortie4->setEtat($ouverte);
        $sortie4->setNbInscriptionsMax(13);

        $sortie5->setCampus($quinper);
        $sortie5->setNom('Bowling ! ');
        $sortie5->setInfosSortie('Pour les fan de Bowling ou juste pour rencontrer les élèves de l\'ENI !');
        $sortie5->setLieu($bow);
        $sortie5->setDateHeureDebut(new \DateTime('2022-02-27 15:00:00'));
        $sortie5->setDateLimiteInscription(new \DateTime('2022-02-26 22:00:00'));
        $sortie5->setDuree(new \DateTime('04:30:00'));
        $sortie5->setOrganisateur($user1);
        $sortie5->setEtat($ouverte);
        $sortie5->setNbInscriptionsMax(18);
        $sortie5->addParticipant($user2);
        $sortie5->addParticipant($user3);
        $sortie5->addParticipant($user4);

        $sortie6->setCampus($quinper);
        $sortie6->setNom('Un petit bowling !!');
        $sortie6->setInfosSortie('Pour les fan de Bowling !');
        $sortie6->setLieu($bow);
        $sortie6->setDateHeureDebut(new \DateTime('2022-03-26 15:00:00'));
        $sortie6->setDateLimiteInscription(new \DateTime('2022-03-25 22:00:00'));
        $sortie6->setDuree(new \DateTime('14:30:00'));
        $sortie6->setOrganisateur($user1);
        $sortie6->setEtat($creation);
        $sortie6->setNbInscriptionsMax(18);
        $sortie6->addParticipant($user2);
        $sortie6->addParticipant($user3);
        $sortie6->addParticipant($user4);

        $sortie7->setCampus($quinper);
        $sortie7->setNom('Rencontre entre élève');
        $sortie7->setInfosSortie('Pour faire connaissance !');
        $sortie7->setLieu($bow);
        $sortie7->setDateHeureDebut(new \DateTime('2022-01-15 15:00:00'));
        $sortie7->setDateLimiteInscription(new \DateTime('2022-01-14 22:00:00'));
        $sortie7->setDuree(new \DateTime('14:30:00'));
        $sortie7->setOrganisateur($user1);
        $sortie7->setEtat($clot);
        $sortie7->setNbInscriptionsMax(18);
        $sortie7->addParticipant($user2);
        $sortie7->addParticipant($user3);
        $sortie7->addParticipant($user4);

        $sortie8->setCampus($quinper);
        $sortie8->setNom('Atelier couture');
        $sortie8->setInfosSortie('Atelier couture, prévoyez vos machines et vos patrons !');
        $sortie8->setLieu($bow);
        $sortie8->setDateHeureDebut(new \DateTime('2022-03-04 15:00:00'));
        $sortie8->setDateLimiteInscription(new \DateTime('2022-03-05 22:00:00'));
        $sortie8->setDuree(new \DateTime('14:30:00'));
        $sortie8->setOrganisateur($user1);
        $sortie8->setEtat($passee);
        $sortie8->setNbInscriptionsMax(18);
        $sortie8->addParticipant($user2);
        $sortie8->addParticipant($user3);
        $sortie8->addParticipant($user4);

        $manager->persist($sortie1);
        $manager->persist($sortie2);
        $manager->persist($sortie3);
        $manager->persist($sortie4);
        $manager->persist($sortie5);
        $manager->persist($sortie6);
        $manager->persist($sortie7);
        $manager->persist($sortie8);

        $manager->flush();
    }
}
