<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Représente une entité de produit avec divers attributs et relations.
 */
#[ORM\Entity(repositoryClass: ProduitRepository::class),
    UniqueEntity(fields:"nom",message:"erreur produit déjà existant 
dans la base",groups:["registration"])]
class Produit
{
    /**

     * L'identifiant unique du produit.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Le nom du produit.
     */
    #[ORM\Column(length: 200)]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Votre nom doit faire au moins {{ limit }} caractères',
        maxMessage: 'Votre nom ne doit pas dépasser {{ limit }} caractères',
        groups: ["all"]
    )]
    #[Antispam(groups:["all"])]
    private ?string $nom = null;

    /**
     * Le prix du produit.
     */
    #[ORM\Column]
    private ?float $prix = null;

    /**
     * La quantité du produit.
     */
    #[ORM\Column]
    private ?int $quantite = null;

    /**
     * Indique si le produit est en rupture de stock.
     */
    #[ORM\Column]
    private ?bool $rupture = null;

    /**
     * Le lien de l'image du produit.
     */
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lienImage = null;

    /**
    * La référence associée au produit.
     */
    #[ORM\OneToOne(targetEntity:Reference::class,cascade:["persist"], fetch:"EAGER")]
    private $reference = null;

    /**
     * @var Collection<int, Distributeur>
     * La collection de distributeurs associés à ce produit.
     */
    #[ORM\ManyToMany(targetEntity: Distributeur::class, cascade:["persist"],inversedBy: 'produits')]

    private Collection $distributeurs;

    /**
     * Constructeur pour initialiser la collection de distributeurs.
     */
    public function __construct()
    {
        $this->distributeurs = new ArrayCollection();
    }

    /**
     * Obtenir l'identifiant unique du produit.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Obtenir le prix du produit.
     *
     * @return float|null
     */
    public function getPrix(): ?float
    {
        return $this->prix;
    }

    /**
     * Définir le prix du produit.
     *
     * @param float $prix
     * @return self
     */
    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Obtenir la quantité du produit.
     *
     * @return int|null
     */
    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    /**
     * Définir la quantité du produit.
     *
     * @param int $quantite
     * @return self
     */
    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Vérifier si le produit est en rupture de stock.
     *
     * @return bool|null
     */
    public function isRupture(): ?bool
    {
        return $this->rupture;
    }

    /**
     * Définir l'état de rupture de stock du produit.
     *
     * @param bool $rupture
     * @return self
     */
    public function setRupture(bool $rupture): static
    {
        $this->rupture = $rupture;

        return $this;
    }

    /**
     * Obtenir le lien de l'image du produit.
     *
     * @return string|null
     */
    public function getLienImage(): ?string
    {
        return $this->lienImage;
    }

    /**
     * Définir le lien de l'image du produit.
     *
     * @param string|null $lienImage
     * @return self
     */
    public function setLienImage(?string $lienImage): static
    {
        $this->lienImage = $lienImage;

        return $this;
    }

    /**
     * Obtenir la référence associée au produit.
     *
     * @return Reference|null
     */
    public function getReference(): ?Reference
    {
        return $this->reference;
    }

    /**
     * Définir la référence associée au produit.
     *
     * @param Reference|null $reference
     * @return self
     */
    public function setReference(?Reference $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Obtenir le nom du produit.
     *
     * @return string|null
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * Définir le nom du produit.
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
     * Obtenir la collection de distributeurs associés à ce produit.
     *
     * @return Collection<int, Distributeur>
     */
    public function getDistributeurs(): Collection
    {
        return $this->distributeurs;
    }

    /**
     * Ajouter un distributeur au produit.
     *
     * @param Distributeur $distributeur
     * @return self
     */
    public function addDistributeur(Distributeur $distributeur): static
    {
        if (!$this->distributeurs->contains($distributeur)) {
            $this->distributeurs[] = $distributeur;
            $distributeur->addProduit($this);
        }

        return $this;
    }

    /**
     * Retirer un distributeur du produit.
     *
     * @param Distributeur $distributeur
     * @return self
     */
    public function removeDistributeur(Distributeur $distributeur): static
    {
        if ($this->distributeurs->removeElement($distributeur)) {
            $distributeur->removeProduit($this);
        }

        return $this;
    }

    /**
     * Valider que le prix et la quantité sont des valeurs positives.
     *
    * @return bool
     */

    #[Assert\IsTrue(message:"Erreur valeurs négatives sur le prix 
ou la quantité")]
    public function isPrixQuantiteValid(): bool
    {
        return is_float($this->getPrix()) && is_int($this->getQuantite()) && $this->getPrix() > 0 && $this->getQuantite() > 0;
    }

    /**
     * Valider que le nom du produit ne contient pas de mots interdits.

     * @param ExecutionContextInterface $context
     */
    #[Assert\Callback()]
    public function isContentValid(ExecutionContextInterface $context)
    {
        $forbiddenWords = ['arme', 'médicament', 'drogue'];

        if (preg_match('#' . implode('|', $forbiddenWords) . '#i', $this->getNom())) {
            $context->buildViolation('Le produit est interdit à la vente')
                ->atPath('produit')
                ->addViolation();
        }
    }
}
