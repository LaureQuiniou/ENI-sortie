<?php

namespace App\Repository;

use App\Entity\Ville;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ville|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ville|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ville[]    findAll()
 * @method Ville[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VilleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ville::class);
    }

    public function findVille($data): array{
       // recherche les 12 premières villes qui correspondent à la saisie de l'utilisateur
        dump('%'.$data.'%');
        return $this->createQueryBuilder('v')
            ->andWhere('v.nom LIKE :nom')
            ->orWhere('v.codePostal LIKE :codePostal')
            //->orWhere('v.nom= %:nom%')
            ->setParameter('codePostal', $data.'%')
            ->setParameter('nom', $data.'%')
            ->orderBy('v.nom', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
}
