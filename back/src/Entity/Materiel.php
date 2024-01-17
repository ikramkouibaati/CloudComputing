<?php

namespace App\Entity;

use App\Repository\MaterielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MaterielRepository::class)]
class Materiel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["materiel"])]
    private ?int $id_materiel = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["materiel"])]
    private ?string $nom = null;

    #[ORM\ManyToMany(targetEntity: Produit::class, mappedBy: 'id_materiel')]
    #[ORM\JoinTable(name: 'asso_materiel_produit')]
    #[ORM\JoinColumn(name: 'id_materiel', referencedColumnName: 'id_materiel')]
    #[ORM\InverseJoinColumn(name: 'id_produit', referencedColumnName: 'id_produit')]
    #[Groups(["materiel"])]
    private Collection $produits;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    public function getIdMateriel(): ?int
    {
        return $this->id_materiel;
    }

    public function setIdMateriel(int $id_materiel): self
    {
        $this->id_materiel = $id_materiel;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits->add($produit);
            $produit->addIdMateriel($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            $produit->removeIdMateriel($this);
        }

        return $this;
    }
}
