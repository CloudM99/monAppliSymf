<?php

namespace App\DataFixtures;

use App\Entity\Distributeur;
use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class JoinDistributeurFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
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
        $produits = [
            'souris' => [$hp, $logitech],
            'écrans' => [$hp, $dell],
            'claviers' => [$hp, $logitech],
            'ordinateurs' => [$hp, $dell, $acer],
            'cartouches encre' => [$epson],
            'imprimantes' => [$epson, $hp],
        ];

        foreach ($produits as $nomProduit => $distributeurs) {
            $produit = $repProduit->findOneBy(['nom' => $nomProduit]);
            if ($produit !== null) {
                foreach ($distributeurs as $distributeur) {
                    $produit->addDistributeur($distributeur);
                }
                $manager->persist($produit);
            } else {
                // Log ou gestion de l'erreur si le produit n'existe pas
                echo "Produit '$nomProduit' non trouvé.\n";
            }
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['group3'];
    }

    public function getDependencies()
    {
        return [
            ProduitFixtures::class,
        ];
    }
}