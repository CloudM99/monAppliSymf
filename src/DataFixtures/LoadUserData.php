<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Classe LoadUserData
 *
 * Cette classe de fixtures charge des utilisateurs de test dans la base de données.
 */
class LoadUserData extends Fixture implements FixtureGroupInterface
{
    private $encoder;

    /**
     * Constructeur pour injecter le service de hachage de mot de passe.
     *
     * @param UserPasswordHasherInterface $encoder Le service de hachage de mot de passe
     */
    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * Charge les utilisateurs de test dans la base de données.
     *
     * @param ObjectManager $manager Le gestionnaire d'objets Doctrine
     */
    public function load(ObjectManager $manager)
    {
        $users = [
            ['username' => 'lucas', 'password' => 'adminpass', 'apitoken' => '12345', 'roles' => ['ROLE_ADMIN']]
        ];

        foreach ($users as $user) {
            $objUser = new User();
            $objUser->setUsername($user['username']);
            $objUser->setPassword($this->encoder->hashPassword($objUser, $user['password']));
            $objUser->setApiToken($user['apitoken']);
            $objUser->setRoles($user['roles']);
            $manager->persist($objUser);
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
        return ['group4'];
    }
}
