<?php

namespace App\Entity\Ventes;

use App\Repository\Ventes\DetailsCommandeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetailsCommandeRepository::class)]
class DetailsCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'detailsCommandes')]
    private ?Produit $produit = null;

    #[ORM\Column]
    private ?int $pu = null;

    #[ORM\Column]
    private ?int $qte = null;

    #[ORM\Column]
    private ?int $totalht = null;

    #[ORM\Column]
    private ?int $totalttc = null;

    #[ORM\ManyToOne(inversedBy: 'detailsCommandes')]
    private ?Commande $commande = null;

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

    public function getPu(): ?int
    {
        return $this->pu;
    }

    public function setPu(int $pu): self
    {
        $this->pu = $pu;

        return $this;
    }

    public function getQte(): ?int
    {
        return $this->qte;
    }

    public function setQte(int $qte): self
    {
        $this->qte = $qte;

        return $this;
    }

    public function getTotalht(): ?int
    {
        return $this->totalht;
    }

    public function setTotalht(int $totalht): self
    {
        $this->totalht = $totalht;

        return $this;
    }

    public function getTotalttc(): ?int
    {
        return $this->totalttc;
    }

    public function setTotalttc(int $totalttc): self
    {
        $this->totalttc = $totalttc;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }
}
