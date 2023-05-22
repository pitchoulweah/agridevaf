<?php

namespace App\Entity\Ventes;

use App\Repository\DetailsGrilleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetailsGrilleRepository::class)]
class DetailsGrille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'detailsGrilles')]
    private ?Produit $produit = null;

    #[ORM\Column]
    private ?int $prix = null;

    #[ORM\ManyToOne(inversedBy: 'detailsGrilles')]
    private ?GrilleTarifaire $grille = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getGrille(): ?GrilleTarifaire
    {
        return $this->grille;
    }

    public function setGrille(?GrilleTarifaire $grille): self
    {
        $this->grille = $grille;

        return $this;
    }
    public function __toString(): string
    {
        return $this->produit;
    }
}
