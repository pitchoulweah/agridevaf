<?php

namespace App\Entity\Ventes;

use App\Repository\Ventes\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\All;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $ref = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_commande = null;

    #[ORM\Column(nullable: true)]
    private ?bool $envoye = null;

    #[ORM\Column(nullable: true)]
    private ?bool $valide = null;

    #[ORM\Column(nullable: true)]
    private ?bool $cloture = null;

    #[ORM\ManyToOne(inversedBy: 'commandes',cascade: ['ALL'])]
    private ?Client $client = null;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: DetailsCommande::class)]
    private Collection $detailsCommandes;


    #[ORM\Column(nullable: true)]
    private ?bool $etre_livre = null;

    #[ORM\Column(nullable: true)]
    private ?bool $livre = null;

    #[ORM\Column(nullable: true)]
    private ?bool $has_tva= null;

    #[ORM\Column(nullable: true)]
    private ?int $tva = null;

    #[ORM\Column(nullable: true)]
    private ?int $ht = null;

    #[ORM\Column(nullable: true)]
    private ?int $ttc = null;


    public function __construct()
    {
        $this->detailsCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function setRef(string $ref): self
    {
        $this->ref = $ref;

        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->date_commande;
    }

    public function setDateCommande(\DateTimeInterface $date_commande): self
    {
        $this->date_commande = $date_commande;

        return $this;
    }

    public function isEnvoye(): ?bool
    {
        return $this->envoye;
    }

    public function setEnvoye(?bool $envoye): self
    {
        $this->envoye = $envoye;

        return $this;
    }

    public function isValide(): ?bool
    {
        return $this->valide;
    }

    public function setValide(?bool $valide): self
    {
        $this->valide = $valide;

        return $this;
    }

    public function isCloture(): ?bool
    {
        return $this->cloture;
    }

    public function setCloture(?bool $cloture): self
    {
        $this->cloture = $cloture;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, DetailsCommande>
     */
    public function getDetailsCommandes(): Collection
    {
        return $this->detailsCommandes;
    }

    public function addDetailsCommande(DetailsCommande $detailsCommande): self
    {
        if (!$this->detailsCommandes->contains($detailsCommande)) {
            $this->detailsCommandes->add($detailsCommande);
            $detailsCommande->setCommande($this);
        }

        return $this;
    }

    public function removeDetailsCommande(DetailsCommande $detailsCommande): self
    {
        if ($this->detailsCommandes->removeElement($detailsCommande)) {
            // set the owning side to null (unless already changed)
            if ($detailsCommande->getCommande() === $this) {
                $detailsCommande->setCommande(null);
            }
        }

        return $this;
    }

    public function isEtreLivre(): ?bool
    {
        return $this->etre_livre;
    }

    public function setEtreLivre(?bool $etre_livre): self
    {
        $this->etre_livre = $etre_livre;

        return $this;
    }

    public function isLivre(): ?bool
    {
        return $this->livre;
    }

    public function setLivre(?bool $livre): self
    {
        $this->livre = $livre;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getHasTva(): ?bool
    {
        return $this->has_tva;
    }

    /**
     * @param bool|null $has_tva
     */
    public function setHasTva(?bool $has_tva): void
    {
        $this->has_tva = $has_tva;
    }

    /**
     * @return int|null
     */
    public function getTva(): ?int
    {
        return $this->tva;
    }

    /**
     * @param int|null $tva
     */
    public function setTva(?int $tva): void
    {
        $this->tva = $tva;
    }

    /**
     * @return int|null
     */
    public function getHt(): ?int
    {
        return $this->ht;
    }

    /**
     * @param int|null $ht
     */
    public function setHt(?int $ht): void
    {
        $this->ht = $ht;
    }

    /**
     * @return int|null
     */
    public function getTtc(): ?int
    {
        return $this->ttc;
    }

    /**
     * @param int|null $ttc
     */
    public function setTtc(?int $ttc): void
    {
        $this->ttc = $ttc;
    }

}
