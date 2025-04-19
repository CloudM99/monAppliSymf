<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
   * Contrôleur RedirectController
    * Gère la redirection de la page d'accueil vers la liste des produits.
 **/
class RedirectController extends AbstractController
{

    #[Route("/", name:"home")]

    public function index(): RedirectResponse
    {
        return $this->redirectToRoute('liste'); // Assure-toi que 'liste' est le nom de la route pour /liste
    }
}