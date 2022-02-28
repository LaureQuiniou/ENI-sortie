<?php

namespace App\Repository;

use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    public function findSorties ($searchData, ParticipantRepository $participantRepository){
        $queryBuilder=$this->createQueryBuilder('s');
        $queryBuilder->leftJoin('s.etat','e')
            ->addSelect('e');
        $queryBuilder->leftJoin('s.participants','p')
            ->addSelect('p');
        $queryBuilder->leftJoin('s.organisateur','o')
            ->addSelect('o');
        $queryBuilder->leftJoin('s.campus','c')
            ->addSelect('c');

        //filtre par campus
        if (!empty($searchData->campus)){
            $queryBuilder->andWhere('o.campus = :campus')
                ->setParameter('campus', $searchData->campus);
        }
        //filtre par mot clef
        if (!empty($searchData->motClef)){
            $queryBuilder->andWhere('s.nom LIKE :motClef')
                ->setParameter('motClef', "%{$searchData->motClef}%");
        }
        //filtre par date de début
        if (!empty($searchData->dateDebut)){
            $queryBuilder->andWhere('s.dateHeureDebut >= :dateDebut')
                ->setParameter('dateDebut', $searchData->dateDebut);
        }
        //filtre date de fin
        if (!empty($searchData->dateFin)){
            $queryBuilder->andWhere('s.dateHeureDebut <= :dateFin')
                ->setParameter('dateFin', $searchData->dateFin);
        }
        //filtre si user est organisateur
        //$participant = $participantRepository->findOneBy($this->getUser()->getId());
        //if (!empty($searchData->est_organisateur)){
        //    $queryBuilder->andWhere('s.organisateur.id == :organisateur')
        //        ->setParameter('organisateur', $participant->getId());
       // }
        //filtre si user est inscrit
        //if (!empty($searchData->est_inscrit)){
        //    $queryBuilder->andWhere('s.participants == :participant')
        //        ->setParameter('participant', $participant->getId());
       // }
        //filtre si user est pas inscrit
        //if (!empty($searchData->pas_inscrit)){
       //     $queryBuilder->andWhere('s.participants !== :participant')
        //        ->setParameter('participant', $participant->getId());
       // }
        //filtre sorties passées
        if(!empty($searchData->sortie_passees)){

        }
        else{

        }

        $query = $queryBuilder->getQuery();
        $paginator = new Paginator($query);
        return $paginator;
    }




}
