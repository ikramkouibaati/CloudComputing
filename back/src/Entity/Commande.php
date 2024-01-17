<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["commande"])]
    private ?int $id_commande = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(["commande"])]
    private ?\DateTimeInterface $date_commande = null;

    #[ORM\Column]
    #[Groups(["commande"])]
    private ?float $prix_total = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    #[ORM\JoinColumn(name: 'id_reduction', referencedColumnName: 'id_reduction', nullable: true)]
    #[Groups(["commande"])]
    private ?Reduction $id_reduction = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    #[ORM\JoinColumn(name: 'id_utilisateur', referencedColumnName: 'id_utilisateur', nullable: false)]
    #[Groups(["commande"])]
    private ?Utilisateur $id_utilisateur = null;

    #[ORM\ManyToOne(inversedBy: 'statut')]
    #[ORM\JoinColumn(name: 'id_statut', referencedColumnName: 'id_statut', nullable: false)]
    private ?Statut $statut = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    #[ORM\JoinColumn(name: 'id_adresse_facturation', referencedColumnName: 'id_adresse_facturation', nullable: false)]
    private ?AdresseFacturation $id_adresse_facturation = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    #[ORM\JoinColumn(name: 'id_adresse_livraison', referencedColumnName: 'id_adresse_livraison', nullable: false)]
    private ?AdresseLivraison $id_adresse_livraison = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    #[ORM\JoinColumn(name: 'id_mode_paiement', referencedColumnName: 'id_mode_paiement', nullable: false)]
    private ?ModePaiement $id_mode_paiement = null;


 /*
    #[ORM\ManyToOne(inversedBy: 'commandes')]
    #[ORM\JoinColumn(name: 'id_reduction ', referencedColumnName: 'id_reduction ', nullable: false)]
    private ?Reduction $reduction = null;

*/


    public function getIdCommande(): ?int
    {
        return $this->id_commande;
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

    public function getPrixTotal(): ?float
    {
        return $this->prix_total;
    }

    public function setPrixTotal(float $prix_total): self
    {
        $this->prix_total = $prix_total;

        return $this;
    }

  /*  public function getIdReduction(): ?Reduction
    {
        return $this->id_reduction;
    }

    public function setIdReduction(?Reduction $id_reduction): self
    {
        $this->id_reduction = $id_reduction;

        return $this;
    }*/


    public function getIdUtilisateur(): ?Utilisateur
    {
        return $this->id_utilisateur;
    }

    public function setIdUtilisateur(?Utilisateur $id_utilisateur): self
    {
        $this->id_utilisateur = $id_utilisateur;

        return $this;
    }

    public function getStatut(): ?Statut
    {
        return $this->statut;
    }

    public function setStatut(?Statut $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getIdAdresseFacturation(): ?AdresseFacturation
    {
        return $this->id_adresse_facturation;
    }

    public function setIdAdresseFacturation(?AdresseFacturation $id_adresse_facturation): self
    {
        $this->id_adresse_facturation = $id_adresse_facturation;

        return $this;
    }


  /*  public function getReduction(): ?int
    {
        return $this->reduction;
    }

    public function setReduction(?int $reduction): self
    {
        $this->reduction = $reduction;

        return $this;
    }
*/


    public function getIdAdresseLivraison(): ?AdresseLivraison
    {
        return $this->id_adresse_livraison;
    }

    public function setIdAdresseLivraison(?AdresseLivraison $id_adresse_livraison): self
    {
        $this->id_adresse_livraison = $id_adresse_livraison;

        return $this;
    }

    public function getIdModePaiement(): ?ModePaiement
    {
        return $this->id_mode_paiement;
    }

    public function setIdModePaiement(?ModePaiement $id_mode_paiement): self
    {
        $this->id_mode_paiement = $id_mode_paiement;

        return $this;
    }
}
