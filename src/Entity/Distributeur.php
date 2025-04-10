<?php

namespace App\Entity;

use App\Repository\DistributeurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Représente une entité de distributeur avec une collection de produits.
 */
#[ORM\Entity(repositoryClass: DistributeurRepository::class)]
class Distributeur
{
    /**
     * L'identifiant unique du distributeur.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Le nom du distributeur.
     */
    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    /**
     * @var Collection<int, Produit>
    * La collection de produits associés à ce distributeur.
     */
    #[ORM\ManyToMany(targetEntity: Produit::class, cascade:["persist"], inversedBy: 'distributeurs')]
    private Collection $produits;

    /**
     * Constructeur pour initialiser la collection de produits.
     */
    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    /**
     * Obtenir l'identifiant unique du distributeur.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Obtenir le nom du distributeur.
     *
     * @return string|null
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * Définir le nom du distributeur.
     *
     * @param string $nom
     * @return self
     */
    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Obtenir la collection de produits associés à ce distributeur.
     *
     * @return Collection<int, Produit>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    /**
     * Ajouter un produit au distributeur.
     *
     * @param Produit $produit
     * @return self
     */
    public function addProduit(Produit $produit): static
    {
        if (!$this->produits->contains($produit)) {
            $this->produits->add($produit);
        }

        return $this;
    }

    /**
     * Retirer un produit du distributeur.
     *
     * @param Produit $produit
     * @return self
     */
    public function removeProduit(Produit $produit): static
    {
        $this->produits->removeElement($produit);

        return $this;
    }
}