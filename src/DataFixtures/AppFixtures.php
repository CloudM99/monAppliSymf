<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Classe AppFixtures
 *
 * Cette classe de fixtures est un exemple de base pour charger des données initiales.
 * Actuellement, elle ne charge aucune donnée spécifique mais peut être étendue pour inclure des données de test.
 */
class AppFixtures extends Fixture
{
    /**
     * Charge les données initiales dans la base de données.
     *
     * @param ObjectManager $manager Le gestionnaire d'objets Doctrine
     */
    public function load(ObjectManager $manager): void
    {
        // Exemple de chargement de données
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
