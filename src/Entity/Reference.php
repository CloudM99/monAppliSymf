<?php

namespace App\Entity;

use App\Repository\ReferenceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
* Représente une entité de référence avec un numéro unique.
 */
#[ORM\Entity(repositoryClass: ReferenceRepository::class)]
class Reference
{
    /**
     * L'identifiant unique de la référence.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Le numéro unique associé à la référence.
     */
    #[ORM\Column]
    private ?int $numero = null;

    /**
     * Obtenir l'identifiant unique de la référence.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Obtenir le numéro unique associé à la référence.
     *
     * @return int|null
     */
    public function getNumero(): ?int
    {
        return $this->numero;
    }

    /**
     * Définir le numéro unique associé à la référence.
     *
     * @param int $numero
     * @return self
     */
    public function setNumero(int $numero): static
    {
        $this->numero = $numero;

        return $this;
    }
}
