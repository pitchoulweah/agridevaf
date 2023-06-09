<?php

namespace App\Entity\Ventes;

use App\Entity\Pays;
use App\Entity\Ville;
use App\Repository\Ventes\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenoms = null;

    #[ORM\Column(length: 100)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse_facturation = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse_livraison = null;


    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Commande::class)]
    private Collection $commandes;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $ville_facturation = null;

        #[ORM\Column(length: 100, nullable: true)]
    private ?string $pays_facturation = null;

        #[ORM\Column(length: 100, nullable: true)]
    private ?string $ville_livraison = null;

        #[ORM\Column(length: 100, nullable: true)]
    private ?string $pays_livraison = null;


    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenoms(): ?string
    {
        return $this->prenoms;
    }

    public function setPrenoms(string $prenoms): self
    {
        $this->prenoms = $prenoms;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAdresseFacturation(): ?string
    {
        return $this->adresse_facturation;
    }

    public function setAdresseFacturation(string $adresse_facturation): self
    {
        $this->adresse_facturation = $adresse_facturation;

        return $this;
    }

    public function getAdresseLivraison(): ?string
    {
        return $this->adresse_livraison;
    }

    public function setAdresseLivraison(string $adresse_livraison): self
    {
        $this->adresse_livraison = $adresse_livraison;

        return $this;
    }



    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->setClient($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getClient() === $this) {
                $commande->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getVilleFacturation(): ?string
    {
        return $this->ville_facturation;
    }

    /**
     * @param string|null $ville_facturation
     */
    public function setVilleFacturation(?string $ville_facturation): void
    {
        $this->ville_facturation = $ville_facturation;
    }

    /**
     * @return string|null
     */
    public function getPaysFacturation(): ?string
    {
        return $this->pays_facturation;
    }

    /**
     * @param string|null $pays_facturation
     */
    public function setPaysFacturation(?string $pays_facturation): void
    {
        $this->pays_facturation = $pays_facturation;
    }

    /**
     * @return string|null
     */
    public function getVilleLivraison(): ?string
    {
        return $this->ville_livraison;
    }

    /**
     * @param string|null $ville_livraison
     */
    public function setVilleLivraison(?string $ville_livraison): void
    {
        $this->ville_livraison = $ville_livraison;
    }

    /**
     * @return string|null
     */
    public function getPaysLivraison(): ?string
    {
        return $this->pays_livraison;
    }

    /**
     * @param string|null $pays_livraison
     */
    public function setPaysLivraison(?string $pays_livraison): void
    {
        $this->pays_livraison = $pays_livraison;
    }

}
