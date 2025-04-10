<?php

namespace App\DataFixtures;

use App\Entity\Distributeur;
use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Classe JoinDistributeurFixtures
 *
 * Cette classe de fixtures crée des relations entre les produits et les distributeurs.
 * Elle associe des distributeurs spécifiques à des produits existants dans la base de données.
 */
class JoinDistributeurFixtures extends Fixture implements FixtureGroupInterface
{
    /**
     * Charge les relations entre les produits et les distributeurs.
     *
     * @param ObjectManager $manager Le gestionnaire d'objets Doctrine
     */
    public function load(ObjectManager $manager)
    {
        $repProduit = $manager->getRepository(Produit::class);

        // Création des distributeurs
        $logitech = new Distributeur();
        $logitech->setNom('Logitech');

        $hp = new Distributeur();
        $hp->setNom('HP');

        $epson = new Distributeur();
        $epson->setNom('Epson');

        $dell = new Distributeur();
        $dell->setNom('Dell');

        $acer = new Distributeur();
        $acer->setNom('Acer');

        // Association des distributeurs aux produits
        $produit = $repProduit->findOneBy(['nom' => 'souris']);
        $produit->addDistributeur($hp);
        $produit->addDistributeur($logitech);

        $produit = $repProduit->findOneBy(['nom' => 'écrans']);
        $produit->addDistributeur($hp);
        $produit->addDistributeur($dell);

        $produit = $repProduit->findOneBy(['nom' => 'claviers']);
        $produit->addDistributeur($hp);
        $produit->addDistributeur($logitech);

        $produit = $repProduit->findOneBy(['nom' => 'ordinateurs']);
        $produit->addDistributeur($hp);
        $produit->addDistributeur($dell);
        $produit->addDistributeur($acer);

        $produit = $repProduit->findOneBy(['nom' => 'cartouches encre']);
        $produit->addDistributeur($epson);

        $produit = $repProduit->findOneBy(['nom' => 'imprimantes']);
        $produit->addDistributeur($epson);
        $produit->addDistributeur($hp);

        $manager->persist($produit);
        $manager->flush();
    }

    /**
     * Retourne les groupes auxquels cette fixture appartient.
     *
     * @return array
     */
    public static function getGroups(): array
    {
        return ['group3'];
    }
}
