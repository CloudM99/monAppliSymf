<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
/**
 * Représente une entité utilisateur avec des propriétés liées à la sécurité.
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    /**
     * L'identifiant unique de l'utilisateur.
     */
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    /**
     *
     * Le nom d'utilisateur.
     */
    private ?string $username = null;

    /**
     * @var list<string>
     * Les rôles attribués à l'utilisateur.
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string
     * Le mot de passe haché de l'utilisateur.
     */
    #[ORM\Column]
    private ?string $password = null;

    /**
    * Le jeton API de l'utilisateur.
     */
    #[ORM\Column(type:"string", unique:true, nullable:true)]
    private $apiToken;

    /**
     * Obtenir l'identifiant unique de l'utilisateur.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Obtenir le nom d'utilisateur.
     *
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * Définir le nom d'utilisateur.
     *
     * @param string $username
     * @return self
     */
    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Un identifiant visuel qui représente cet utilisateur.
     *
     * @see UserInterface
     * @return string
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * Obtenir les rôles attribués à l'utilisateur.
     *
     * @see UserInterface
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * Définir les rôles attribués à l'utilisateur.
     *
     * @param list<string> $roles
     * @return self
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Obtenir le mot de passe haché de l'utilisateur.
     *
     * @see PasswordAuthenticatedUserInterface
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Définir le mot de passe haché de l'utilisateur.
     *
     * @param string $password
     * @return self
     */
    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Effacer les informations sensibles de l'utilisateur.
     *
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // Effacer les données sensibles si nécessaire
    }

    /**
     * Obtenir le jeton API de l'utilisateur.
     *
     * @return string|null
     */
    public function getApiToken(): ?string
    {
        return $this->apiToken;
    }

    /**
     * Définir le jeton API de l'utilisateur.
     *
     * @param string|null $apiToken
     * @return self
     */
    public function setApiToken(?string $apiToken): static
    {
        $this->apiToken = $apiToken;

        return $this;
    }
}
