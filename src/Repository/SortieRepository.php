<?php

namespace App\Repository;

use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

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
    public function findSorties() {
        $queryBuilder=$this->createQueryBuilder('s');
        $queryBuilder->leftJoin('s.etat','e')
            ->addSelect('e');
        $queryBuilder->leftJoin('s.participants','p')
            ->addSelect('p');
        $queryBuilder->leftJoin('s.organisateur','o')
            ->addSelect('o');
        $queryBuilder->leftJoin('s.campus','c')
            ->addSelect('c');
        $query = $queryBuilder->getQuery();
        $paginator = new Paginator($query);
        return $paginator;
    }

    public function searchSortiesAvecFiltres ($searchData, UserInterface $user){

        //dd($searchData['est_inscrit'],$searchData['pas_inscrit'], $searchData['sorties_passees']);
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
        if (!empty($searchData['campus'])){
            $queryBuilder->andWhere('c.id = :campus')
                ->setParameter('campus', $searchData['campus']->getId());
        }
        //filtre par mot clef
        if (!empty($searchData['motClef'])){
            $queryBuilder->andWhere('s.nom LIKE :motClef')
                ->setParameter('motClef', '%'.$searchData['motClef'].'%');
            //$query->where('MATCH_AGAINST(s.nom, s.infosSortie) AGAINST (:mots boolean)>0')
             //   ->setParameter('mots', $mots);
        }
        //filtre par date de début
        if (!empty($searchData['dateDebut'])){
            $queryBuilder->andWhere('s.dateHeureDebut >= :dateDebut')
                ->setParameter('dateDebut', $searchData['dateDebut']);
        }
        //filtre date de fin
        if (!empty($searchData['dateFin'])){
            $queryBuilder->andWhere('s.dateHeureDebut <= :dateFin')
                ->setParameter('dateFin', $searchData['dateFin']);
        }
        //filtre si user est organisateur
        if (!empty($searchData['est_organisateur'])){
           $queryBuilder->andWhere('o.id = :organisateurId')
               ->setParameter('organisateurId', $user->getId());
        }
        //filtre si user est inscrit
        if ($searchData['est_inscrit']){
            $queryBuilder->andWhere('p.id = :userId')
               ->setParameter('userId', $user->getId());
       }
        //filtre si user est pas inscrit
        if (!empty($searchData['pas_inscrit'])){
           $queryBuilder->andWhere('p.id != :userId')
               ->setParameter('userId', $user->getId());
        }
        //filtre sorties passées
        if(!empty($searchData['sorties_passees'])){
            $queryBuilder->andWhere('s.dateHeureDebut < :today')
                ->setParameter('today', date('Y/m/d'));
        }

        $query = $queryBuilder->getQuery();
        //dd($query);
        $paginator = new Paginator($query);
        return $paginator;
    }




}
