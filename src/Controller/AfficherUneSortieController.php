<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AfficherUneSortieController extends AbstractController
{

    /**
     * @Route ("/afficherSortie", name="afficher_sortie")
     */
    public function afficherSortie()
    {
        return $this->render('afficher_une_sortie/afficherSortie.html.twig');
    }
}
