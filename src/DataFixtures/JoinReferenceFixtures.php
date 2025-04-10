<?php

namespace App\DataFixtures;

use App\Entity\Produit;
use App\Entity\Reference;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Classe JoinReferenceFixtures
 *
 * Cette classe de fixtures associe une référence à chaque produit dans la base de données.
 */
class JoinReferenceFixtures extends Fixture implements FixtureGroupInterface
{
    /**
     * Charge les références pour chaque produit.
     *
     * @param ObjectManager $manager Le gestionnaire d'objets Doctrine
     */
    public function load(ObjectManager $manager)
    {
        $repProduit = $manager->getRepository(Produit::class);
        $listeProduits = $repProduit->findAll();

        foreach ($listeProduits as $monProduit) {
            $reference = new Reference();
            $reference->setNumero(rand());
            $monProduit->setReference($reference);
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
        return ['group2'];
    }
}
