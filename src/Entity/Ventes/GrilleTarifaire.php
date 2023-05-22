<?php

namespace App\Entity\Ventes;

use App\Repository\GrilleTarifaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GrilleTarifaireRepository::class)]
class GrilleTarifaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(nullable: true)]
    private ?bool $actif = null;

    #[ORM\OneToMany(mappedBy: 'grille', targetEntity: DetailsGrille::class)]
    private Collection $detailsGrilles;

    public function __construct()
    {
        $this->detailsGrilles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }
    public function __toString(): string
    {
        return $this->libelle;
    }

    public function isActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(?bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * @return Collection<int, DetailsGrille>
     */
    public function getDetailsGrilles(): Collection
    {
        return $this->detailsGrilles;
    }

    public function addDetailsGrille(DetailsGrille $detailsGrille): self
    {
        if (!$this->detailsGrilles->contains($detailsGrille)) {
            $this->detailsGrilles->add($detailsGrille);
            $detailsGrille->setGrille($this);
        }

        return $this;
    }

    public function removeDetailsGrille(DetailsGrille $detailsGrille): self
    {
        if ($this->detailsGrilles->removeElement($detailsGrille)) {
            // set the owning side to null (unless already changed)
            if ($detailsGrille->getGrille() === $this) {
                $detailsGrille->setGrille(null);
            }
        }

        return $this;
    }
}
