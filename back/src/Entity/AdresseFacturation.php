<?php

namespace App\Entity;

use App\Repository\AdresseFacturationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdresseFacturationRepository::class)]
class AdresseFacturation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_adresse_facturation = null;

    #[ORM\Column(length: 255)]
    private ?string $rue = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $complement_adresse = null;

    #[ORM\Column(length: 255)]
    private ?string $region = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\Column]
    private ?int $code_postal = null;

    #[ORM\Column(length: 255)]
    private ?string $pays = null;

    #[ORM\OneToMany(mappedBy: 'id_adresse_facturation', targetEntity: Commande::class)]
    private Collection $commandes;

    #[ORM\ManyToMany(targetEntity: Utilisateur::class, mappedBy: 'adresses_facturation')]
    #[ORM\JoinTable(name: 'asso_adresse_facturation_utilisateur')]
    #[ORM\JoinColumn(name: 'id_adresse_facturation', referencedColumnName: 'id_adresse_facturation')]
    #[ORM\InverseJoinColumn(name: 'id_utilisateur', referencedColumnName: 'id_utilisateur')]
    private Collection $utilisateurs;

    #[ORM\Column]
    private ?bool $carnet_adresse = null;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->utilisateurs = new ArrayCollection();
    }

    public function getIdAdresseFacturation(): ?int
    {
        return $this->id_adresse_facturation;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): self
    {
        $this->rue = $rue;

        return $this;
    }

    public function getComplementAdresse(): ?string
    {
        return $this->complement_adresse;
    }

    public function setComplementAdresse(?string $complement_adresse): self
    {
        $this->complement_adresse = $complement_adresse;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->code_postal;
    }

    public function setCodePostal(int $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

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
            $commande->setIdAdresseFacturation($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
         
            if ($commande->getIdAdresseFacturation() === $this) {
                $commande->setIdAdresseFacturation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(Utilisateur $utilisateur): self
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs->add($utilisateur);
            $utilisateur->addAdressesFacturation($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        if ($this->utilisateurs->removeElement($utilisateur)) {
            $utilisateur->removeAdressesFacturation($this);
        }

        return $this;
    }

    public function isCarnetAdresse(): ?bool
    {
        return $this->carnet_adresse;
    }

    public function setCarnetAdresse(bool $carnet_adresse): self
    {
        $this->carnet_adresse = $carnet_adresse;

        return $this;
    }
}
