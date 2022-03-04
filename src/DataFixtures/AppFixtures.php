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
        $quimper = new Campus();
        $quimper->setNom('Quimper');
        $stHerblain = new Campus();
        $stHerblain -> setNom('Saint-Herblain');
        $chartres = new Campus();
        $chartres ->setNom('Chartres-de-Bretagne');
        $roche = new Campus();
        $roche -> setNom('La Roche-Sur-Yon');
        $manager->persist($quimper);
        $manager->persist($stHerblain);
        $manager->persist($chartres);
        $manager->persist($roche);


        // Villes
        $villeQuimper = new Ville();
        $villeRoche = new Ville();
        $villeStHerblain = new Ville();
        $villeNantes = new Ville();
        $villeChartres= new Ville();
        $villeQuimper->setNom('QUIMPER');
        $villeRoche->setNom('La-ROCHE-SUR-YON');
        $villeNantes->setNom('NANTES');
        $villeStHerblain->setNom('SAINT-HERBLAIN');
        $villeChartres->setNom('CHARTRES-DE-BRETAGNE');
        $villeQuimper->setCodePostal('29000');
        $villeRoche->setCodePostal('85000');
        $villeNantes->setCodePostal('44000');
        $villeStHerblain->setCodePostal('44162');
        $villeChartres->setCodePostal('35131');
        $manager->persist($villeNantes);
        $manager->persist($villeRoche);
        $manager->persist($villeStHerblain);
        $manager->persist($villeQuimper);
        $manager->persist($villeChartres);

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
        $cat = new Lieu();
        $cat->setNom('centre-ville');
        $cat->setRue('centre ville');
        $cat->setVille($villeChartres);
        $manager->persist($chat);
        $manager->persist($quai);
        $manager->persist($bow);
        $manager->persist($pat);
        $manager->persist($cat);

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
        $user5 = new Participant();
        $user6 = new Participant();
        $user7 = new Participant();
        $user8 = new Participant();

        $user1->setNom('Dupond');
        $user1->setPrenom('Bernard');
        $user1->setEmail('admin@eni.com');
        $user1->setRoles(["ROLE_ADMIN"]);
        $user1->setPassword('$2y$13$6Iwj4bq8eWGgYEu8OPfn6uZkCm6YZcph45u9MsJTR3QnStIZ8xRdy');
        $user1->setPseudo('adminou');
        $user1->setTelephone('01.35.45.78.65');
        $user1->setActif(true);
        $user1->setSuppression(false);
        $user1->setCampus($chartres);
        $user1->setPhoto('avataaars(1).png');

        $user2->setNom('Duprès');
        $user2->setPrenom('Natalie');
        $user2->setEmail('user@eni.com');
        $user2->setRoles(["ROLE_USER"]);
        $user2->setPassword('$2y$13$6Iwj4bq8eWGgYEu8OPfn6uZkCm6YZcph45u9MsJTR3QnStIZ8xRdy');
        $user2->setPseudo('userinou');
        $user2->setTelephone('05.45.78.36.67');
        $user2->setActif(true);
        $user2->setSuppression(false);
        $user2->setCampus($stHerblain);
        $user2->setPhoto('avataaars(2).png');

        $user3->setNom('Le Kerguerec');
        $user3->setPrenom('Yohann');
        $user3->setEmail('organisateur@eni.com');
        $user3->setRoles(["ROLE_USER"]);
        $user3->setPassword('$2y$13$6Iwj4bq8eWGgYEu8OPfn6uZkCm6YZcph45u9MsJTR3QnStIZ8xRdy');
        $user3->setPseudo('organinou');
        $user3->setTelephone('07.32.98.54.22');
        $user3->setActif(true);
        $user3->setSuppression(false);
        $user3->setCampus($quimper);
        $user3->setPhoto('avataaars.png');

        $user4->setNom('Marteau');
        $user4->setPrenom('Pierre');
        $user4->setEmail('participant@eni.com');
        $user4->setRoles(["ROLE_USER"]);
        $user4->setPassword('$2y$13$6Iwj4bq8eWGgYEu8OPfn6uZkCm6YZcph45u9MsJTR3QnStIZ8xRdy');
        $user4->setPseudo('participinou');
        $user4->setTelephone('02.55.84.10.74');
        $user4->setActif(true);
        $user4->setSuppression(false);
        $user4->setCampus($roche);

        $user5->setNom('LUSSEAU');
        $user5->setPrenom('Julie');
        $user5->setEmail('julie@eni.com');
        $user5->setRoles(["ROLE_USER"]);
        $user5->setPassword('$2y$13$6Iwj4bq8eWGgYEu8OPfn6uZkCm6YZcph45u9MsJTR3QnStIZ8xRdy');
        $user5->setPseudo('juju');
        $user5->setTelephone('02.55.84.10.74');
        $user5->setActif(true);
        $user5->setSuppression(false);
        $user5->setCampus($roche);

        $user6->setNom('QUINIOU');
        $user6->setPrenom('Laure');
        $user6->setEmail('laure@eni.com');
        $user6->setRoles(["ROLE_USER"]);
        $user6->setPassword('$2y$13$6Iwj4bq8eWGgYEu8OPfn6uZkCm6YZcph45u9MsJTR3QnStIZ8xRdy');
        $user6->setPseudo('lolo');
        $user6->setTelephone('02.55.84.10.74');
        $user6->setActif(true);
        $user6->setSuppression(false);
        $user6->setCampus($quimper);

        $user7->setNom('DUPUY');
        $user7->setPrenom('Aurélie');
        $user7->setEmail('aurelie@eni.com');
        $user7->setRoles(["ROLE_USER"]);
        $user7->setPassword('$2y$13$6Iwj4bq8eWGgYEu8OPfn6uZkCm6YZcph45u9MsJTR3QnStIZ8xRdy');
        $user7->setPseudo('lili');
        $user7->setTelephone('02.55.84.10.74');
        $user7->setActif(true);
        $user7->setSuppression(false);
        $user7->setCampus($stHerblain);

        $user8->setNom('GUILLOU');
        $user8->setPrenom('Marie');
        $user8->setEmail('marie@eni.com');
        $user8->setRoles(["ROLE_USER"]);
        $user8->setPassword('$2y$13$6Iwj4bq8eWGgYEu8OPfn6uZkCm6YZcph45u9MsJTR3QnStIZ8xRdy');
        $user8->setPseudo('riri');
        $user8->setTelephone('02.55.84.10.74');
        $user8->setActif(true);
        $user8->setSuppression(false);
        $user8->setCampus($quimper);


        $manager->persist($user1);
        $manager->persist($user2);
        $manager->persist($user3);
        $manager->persist($user4);
        $manager->persist($user5);
        $manager->persist($user6);
        $manager->persist($user7);
        $manager->persist($user8);

        //Sorties
        $sortie1 = new Sortie();
        $sortie2 = new Sortie();
        $sortie3 = new Sortie();
        $sortie4 = new Sortie();
        $sortie5 = new Sortie();
        $sortie6 = new Sortie();
        $sortie7 = new Sortie();
        $sortie8 = new Sortie();
        $sortie9 = new Sortie();
        $sortie10 = new Sortie();

        $sortie1->setCampus($roche);
        $sortie1->setNom('Allez boire un verre');
        $sortie1->setInfosSortie('Rendez-vous à 19h au ok quais bar. Pour ceux qui le souhaite nous pourrons ensuite allez manger ensemble :)!');
        $sortie1->setLieu($quai);
        $sortie1->setDateHeureDebut(new \DateTime('2022-03-12 19:00:00'));
        $sortie1->setDateLimiteInscription(new \DateTime('2022-03-11 19:00:00'));
        $sortie1->setDuree(new \DateTime('02:00:00'));
        $sortie1->setOrganisateur($user3);
        $sortie1->setEtat($ouverte);
        $sortie1->setNbInscriptionsMax(10);
        $sortie1->addParticipant($user2);
        $sortie1->addParticipant($user1);
        $sortie1->addParticipant($user4);
        $sortie1->addParticipant($user6);
        $sortie1->addParticipant($user8);

        $sortie2->setCampus($stHerblain);
        $sortie2->setNom('Un resto ca vous dit?');
        $sortie2->setInfosSortie('Un petit resto pour faire connaissance! Les anciens et les nouveaux de l\'ENI sont les bienvenus!');
        $sortie2->setLieu($chat);
        $sortie2->setDateHeureDebut(new \DateTime('2022-03-16 12:00:00'));
        $sortie2->setDateLimiteInscription(new \DateTime('2022-03-15 22:00:00'));
        $sortie2->setDuree(new \DateTime('02:00:00'));
        $sortie2->setOrganisateur($user2);
        $sortie2->setEtat($ouverte);
        $sortie2->setNbInscriptionsMax(6);
        $sortie2->addParticipant($user3);
        $sortie2->addParticipant($user2);
        $sortie2->addParticipant($user7);
        $sortie2->addParticipant($user1);

        $sortie3->setCampus($chartres);
        $sortie3->setNom('Rencontre à la patinoire de la Roche');
        $sortie3->setInfosSortie('Glissade à la patinoire de la Roche sur Yon. Rendez-vous à 14h devant la patinoire!');
        $sortie3->setLieu($pat);
        $sortie3->setDateHeureDebut(new \DateTime('2022-03-04 14:00:00'));
        $sortie3->setDateLimiteInscription(new \DateTime('2022-03-03 22:00:00'));
        $sortie3->setDuree(new \DateTime('04:00:00'));
        $sortie3->setOrganisateur($user2);
        $sortie3->setEtat($enCours);
        $sortie3->setNbInscriptionsMax(15);
        $sortie3->addParticipant($user1);
        $sortie3->addParticipant($user4);
        $sortie3->addParticipant($user5);
        $sortie3->addParticipant($user2);
        $sortie3->addParticipant($user3);

        $sortie4->setCampus($roche);
        $sortie4->setNom('Rencontre au OK Quais Bar');
        $sortie4->setInfosSortie('Rendez-vous à 19h au ok quais bar. Comme la dernière fois un resto est prévu pour ceux qui le souhaiteront!');
        $sortie4->setLieu($quai);
        $sortie4->setDateHeureDebut(new \DateTime('2022-03-01 19:00:00'));
        $sortie4->setDateLimiteInscription(new \DateTime('2022-02-28 19:00:00'));
        $sortie4->setDuree(new \DateTime('03:00:00'));
        $sortie4->setOrganisateur($user3);
        $sortie4->setEtat($passee);
        $sortie4->setNbInscriptionsMax(13);

        $sortie5->setCampus($quimper);
        $sortie5->setNom('Bowling ! ');
        $sortie5->setInfosSortie('Pour les fan de Bowling ou juste pour rencontrer les élèves de l\'ENI !');
        $sortie5->setLieu($bow);
        $sortie5->setDateHeureDebut(new \DateTime('2022-03-05 15:00:00'));
        $sortie5->setDateLimiteInscription(new \DateTime('2022-03-03 22:00:00'));
        $sortie5->setDuree(new \DateTime('04:30:00'));
        $sortie5->setOrganisateur($user1);
        $sortie5->setEtat($clot);
        $sortie5->setNbInscriptionsMax(18);
        $sortie5->addParticipant($user2);
        $sortie5->addParticipant($user3);
        $sortie5->addParticipant($user4);
        $sortie5->addParticipant($user1);

        $sortie6->setCampus($quimper);
        $sortie6->setNom('Un petit bowling !!');
        $sortie6->setInfosSortie('Pour les fan de Bowling !');
        $sortie6->setLieu($bow);
        $sortie6->setDateHeureDebut(new \DateTime('2022-03-26 15:00:00'));
        $sortie6->setDateLimiteInscription(new \DateTime('2022-03-25 22:00:00'));
        $sortie6->setDuree(new \DateTime('14:30:00'));
        $sortie6->setOrganisateur($user1);
        $sortie6->setEtat($creation);
        $sortie6->setNbInscriptionsMax(18);


        $sortie7->setCampus($quimper);
        $sortie7->setNom('Rencontre entre élève');
        $sortie7->setInfosSortie('Pour faire connaissance !');
        $sortie7->setLieu($bow);
        $sortie7->setDateHeureDebut(new \DateTime('2022-01-15 15:00:00'));
        $sortie7->setDateLimiteInscription(new \DateTime('2022-01-14 22:00:00'));
        $sortie7->setDuree(new \DateTime('14:30:00'));
        $sortie7->setOrganisateur($user1);
        $sortie7->setEtat($passee);
        $sortie7->setNbInscriptionsMax(18);
        $sortie7->addParticipant($user2);
        $sortie7->addParticipant($user3);
        $sortie7->addParticipant($user4);
        $sortie6->addParticipant($user1);
        $sortie6->addParticipant($user6);
        $sortie6->addParticipant($user5);

        $sortie8->setCampus($quimper);
        $sortie8->setNom('Atelier couture');
        $sortie8->setInfosSortie('Atelier couture, prévoyez vos machines et vos patrons !');
        $sortie8->setLieu($bow);
        $sortie8->setDateHeureDebut(new \DateTime('2022-03-05 15:00:00'));
        $sortie8->setDateLimiteInscription(new \DateTime('2022-03-04 22:00:00'));
        $sortie8->setDuree(new \DateTime('14:30:00'));
        $sortie8->setOrganisateur($user1);
        $sortie8->setEtat($annulee);
        $sortie8->setNbInscriptionsMax(18);
        $sortie8->addParticipant($user2);
        $sortie8->addParticipant($user3);
        $sortie8->addParticipant($user4);

        $sortie9->setCampus($chartres);
        $sortie9->setNom('Construire la cathédrale');
        $sortie9->setInfosSortie('ca vaut le détour ! !');
        $sortie9->setLieu($cat);
        $sortie9->setDateHeureDebut(new \DateTime('2022-03-05 15:00:00'));
        $sortie9->setDateLimiteInscription(new \DateTime('2022-03-04 22:00:00'));
        $sortie9->setDuree(new \DateTime('14:30:00'));
        $sortie9->setOrganisateur($user1);
        $sortie9->setEtat($annulee);
        $sortie9->setNbInscriptionsMax(10);
        $sortie9->addParticipant($user2);
        $sortie9->addParticipant($user3);
        $sortie9->addParticipant($user4);

        $sortie10->setCampus($chartres);
        $sortie10->setNom('ville du 35');
        $sortie10->setInfosSortie('jolie!');
        $sortie10->setLieu($cat);
        $sortie10->setDateHeureDebut(new \DateTime('2022-03-05 15:00:00'));
        $sortie10->setDateLimiteInscription(new \DateTime('2022-03-03 22:00:00'));
        $sortie10->setDuree(new \DateTime('14:30:00'));
        $sortie10->setOrganisateur($user5);
        $sortie10->setEtat($clot);
        $sortie10->setNbInscriptionsMax(20);
        $sortie10->addParticipant($user1);
        $sortie10->addParticipant($user3);
        $sortie10->addParticipant($user5);
        $sortie10->addParticipant($user7);

        $manager->persist($sortie1);
        $manager->persist($sortie2);
        $manager->persist($sortie3);
        $manager->persist($sortie4);
        $manager->persist($sortie5);
        $manager->persist($sortie6);
        $manager->persist($sortie7);
        $manager->persist($sortie8);
        $manager->persist($sortie9);
        $manager->persist($sortie10);

        $manager->flush();
    }
}
