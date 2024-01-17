<?php

namespace App\Entity;

use App\Repository\ModePaiementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModePaiementRepository::class)]
class ModePaiement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_mode_paiement = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\ManyToMany(targetEntity: Utilisateur::class, inversedBy: 'modePaiements')]
    #[ORM\JoinTable(name: 'asso_utilisateur_paiement')]
    #[ORM\JoinColumn(name: 'id_mode_paiement', referencedColumnName: 'id_mode_paiement')]
    #[ORM\InverseJoinColumn(name: 'id_utilisateur', referencedColumnName: 'id_utilisateur')]
    private Collection $id_utilisateur;

    #[ORM\OneToMany(mappedBy: 'id_mode_paiement', targetEntity: Commande::class)]
    private Collection $commandes;

    public function __construct()
    {
        $this->id_utilisateur = new ArrayCollection();
        $this->commandes = new ArrayCollection();
    }

    public function getIdModePaiement(): ?int
    {
        return $this->id_mode_paiement;
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

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getIdUtilisateur(): Collection
    {
        return $this->id_utilisateur;
    }

    public function addIdUtilisateur(Utilisateur $idUtilisateur): self
    {
        if (!$this->id_utilisateur->contains($idUtilisateur)) {
            $this->id_utilisateur->add($idUtilisateur);
        }

        return $this;
    }

    public function removeIdUtilisateur(Utilisateur $idUtilisateur): self
    {
        $this->id_utilisateur->removeElement($idUtilisateur);

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
            $commande->setIdModePaiement($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getIdModePaiement() === $this) {
                $commande->setIdModePaiement(null);
            }
        }

        return $this;
    }
}
