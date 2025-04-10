<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use App\Entity\Produit;

/**
 * Classe UpdateImgProduitFixtures
 *
 * Cette classe de fixtures met à jour les liens d'images pour les produits existants dans la base de données.
 */
class UpdateImgProduitFixtures extends Fixture implements FixtureGroupInterface
{
    /**
     * Met à jour les liens d'images pour les produits.
     *
     * @param ObjectManager $manager Le gestionnaire d'objets Doctrine
     */
    public function load(ObjectManager $manager): void
    {
        $repProduit = $manager->getRepository(Produit::class);
        $listeProduits = $repProduit->findAll();

        foreach ($listeProduits as $monProduit) {
            switch ($monProduit->getNom()) {
                case 'imprimantes':
                    $monProduit->setLienImage("imprimante.jpg");
                    break;
                case 'cartouches encre':
                    $monProduit->setLienImage("cartouche.jpg");
                    break;
                case 'ordinateurs':
                    $monProduit->setLienImage("ordinateur.jpg");
                    break;
                case 'écrans':
                    $monProduit->setLienImage("ecran.jpg");
                    break;
                case 'claviers':
                    $monProduit->setLienImage("clavier.jpg");
                    break;
                case 'souris':
                    $monProduit->setLienImage("souris.jpg");
                    break;
            }
            $manager->persist($monProduit);
        }

        $manager->flush();
    }

    /**
     * Retourne les groupes auxquels cette fixture appartient.
     *
     * @return array
     */
    public static function getGroups(): array
    {
        return ['group1'];
    }
}
