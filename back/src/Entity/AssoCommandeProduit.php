<?php

namespace App\Entity;

use App\Repository\AssoCommandeProduitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssoCommandeProduitRepository::class)]
/**
 * @ORM\Entity(repositoryClass="App\Repository\AssoCommandeProduitRepository")
 * @ORM\Table(name="asso_commande_produit")
 */

class AssoCommandeProduit
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: 'Produit', inversedBy: 'assoCommandeProduits')]
    #[ORM\JoinColumn(name: 'id_produit', referencedColumnName: 'id_produit', nullable: false)]
    private ?Produit $id_produit = null;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: 'Commande', inversedBy: 'assoCommandeProduits')]
    #[ORM\JoinColumn(name: 'id_commande', referencedColumnName: 'id_commande', nullable: false)]
    private ?Commande $id_commande = null;

    #[ORM\Column]
    private ?int $quantite = null;

   /* public function getId(): ?int
    {
        return $this->id;
    }*/

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getIdProduit(): ?Produit
    {
        return $this->id_produit;
    }

    public function setIdProduit(?Produit $id_produit): self
    {
        $this->id_produit = $id_produit;

        return $this;
    }

    public function getIdCommande(): ?Commande
    {
        return $this->id_commande;
    }

    public function setIdCommande(?Commande $id_commande): self
    {
        $this->id_commande = $id_commande;

        return $this;
    }
}
