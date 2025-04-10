<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Data\ListeProduits;
use App\Entity\Produit;

/**
 * Classe ProduitFixtures
 *
 * Cette classe de fixtures charge une liste de produits de test dans la base de données.
 */
class ProduitFixtures extends Fixture
{
    /**
     * Charge les produits de test dans la base de données.
     *
     * @param ObjectManager $manager Le gestionnaire d'objets Doctrine
     */
    public function load(ObjectManager $manager): void
    {
        foreach (ListeProduits::$mesProduits as $monProduit) {
            $produit = new Produit();
            $produit->setNom($monProduit['nom']);
            $produit->setPrix($monProduit['prix']);
            $produit->setQuantite($monProduit['quantite']);
            $produit->setRupture($monProduit['rupture']);
            $manager->persist($produit);
        }

        $manager->flush();
    }
}
