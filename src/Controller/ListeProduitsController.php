<?php

namespace App\Controller;

use App\Entity\Distributeur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Produit;

/**
 * Contrôleur ListeProduitsController
 *
 * Gère l'affichage des listes de produits et de distributeurs.
 */

class ListeProduitsController extends AbstractController
{
    /**
     * Affiche la liste de tous les produits.
     *
     * @param EntityManagerInterface $entityManager Le gestionnaire d'entités Doctrine
     * @return Response La réponse HTTP
     */
    #[Route('/', name: 'liste')]
    public function liste(EntityManagerInterface $entityManager)
    {

        $produitsRepository=$entityManager->getRepository(Produit::class);


        $listeProduits=$produitsRepository->findAll();
        $lastProduit=$produitsRepository->getLastProduit();

        return $this->render('liste_produits/index.html.twig', [
            'listeproduits' => $listeProduits,
            'lastproduit' => $lastProduit
        ]);
    }

    /**
     * Affiche la liste de tous les distributeurs.
     *
     * @param EntityManagerInterface $entityManager Le gestionnaire d'entités Doctrine
     * @return Response La réponse HTTP
     */
    #[Route('/distrib', name:"distributeurs")]
    public function listedistributeur(EntityManagerInterface $entityManager)
    {

        $repositoryDistributeurs=$entityManager->getRepository(Distributeur::class);
        $distributeurs=$repositoryDistributeurs->findAll();


        return $this->render('liste_produits/distributeurs.html.twig',
            array('distributeurs'=>$distributeurs));
    }

    /**
     * Affiche la liste des produits avec chargement eager.
     *
     * @param EntityManagerInterface $entityManager Le gestionnaire d'entités Doctrine
     * @return Response La réponse HTTP
     */
    #[Route("/eager", name:"eager")]
    public function eager(EntityManagerInterface $entityManager)
    {
        $produitsRepository=$entityManager->getRepository(Produit::class);
        $listeProduits=$produitsRepository->findAll();
        return $this->render('liste_produits/eager.html.twig',
        [
            'listeproduits'=>$listeProduits,
        ]);
    }

    /**
     * Retourne une réponse JSON avec les noms des produits.
     *
     * @param EntityManagerInterface $entityManager Le gestionnaire d'entités Doctrine
     * @return JsonResponse La réponse JSON
     */
    #[Route("/apitest", name:"apitest")]
    public function apiTest(EntityManagerInterface $entityManager)
    {
        $produitsRepository=$entityManager->getRepository(Produit::class);
        $listeProduits=$produitsRepository->findAll();
        $resultat=[];
        foreach($listeProduits as $produit){

            array_push($resultat, $produit->getNom());

        }
        $reponse=new JsonResponse($resultat);
        return $reponse;

    }



}