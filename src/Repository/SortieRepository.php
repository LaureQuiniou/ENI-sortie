<?php

namespace App\Repository;

use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

    public function findSorties (){
        $queryBuilder=$this->createQueryBuilder('s');
        $queryBuilder->leftJoin('s.etat','etat')
            ->addSelect('etat');
        $queryBuilder->leftJoin('s.organisateur','participant')
            ->addSelect('participant');
        $query = $queryBuilder->getQuery();
        $paginator = new Paginator($query);
        return $paginator;
    }

    public function compteInscrits(Sortie $sortie){
        $queryBuilder=$this->createQueryBuilder('s');
        $queryBuilder->select('COUNT(participant.id)')
                    ->innerJoin('s.participants', 'participants' )
                    ->andWhere('sortie.id = :sortie')
                    ->setParameter('sortie', $sortie);
        $query = $queryBuilder->getQuery();
        $paginator = new Paginator($query);
        return $paginator;
    }

    // /**
    //  * @return Sortie[] Returns an array of Sortie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sortie
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
