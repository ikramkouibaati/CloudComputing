<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["product"])]
    private ?int $id_produit = null;

    #[ORM\Column(length: 255)]
    #[Groups(["product"])]
    private ?string $nom_produit = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(["product"])]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(["product"])]
    private ?int $stock = null;

    #[ORM\Column]
    #[Groups(["product"])]
    private ?float $prix = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(["product"])]
    private ?\DateTimeInterface $date_ajout = null;

    #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: 'produits')]
    #[ORM\JoinColumn(name: 'id_categorie', referencedColumnName: 'id_categorie', nullable: false)]
    private ?Categorie $id_categorie = null;

   
    #[ORM\OneToMany(mappedBy: 'id_produit', targetEntity: Image::class)]
    #[Groups(["product"])]
    private Collection $images;

    #[ORM\ManyToMany(targetEntity: Materiel::class, inversedBy: 'produits')]
    #[ORM\JoinTable(name: 'asso_materiel_produit')]
    #[ORM\JoinColumn(name: 'id_produit', referencedColumnName: 'id_produit')]
    #[ORM\InverseJoinColumn(name: 'id_materiel', referencedColumnName: 'id_materiel')]
    private Collection $id_materiel;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->id_materiel = new ArrayCollection();
    }

    public function getIdProduit(): ?int
    {
        return $this->id_produit;
    }

    public function getNomProduit(): ?string
    {
        return $this->nom_produit;
    }

    public function setNomProduit(string $nom_produit): self
    {
        $this->nom_produit = $nom_produit;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->date_ajout;
    }

    public function setDateAjout(\DateTimeInterface $date_ajout): self
    {
        $this->date_ajout = $date_ajout;

        return $this;
    }

    public function getIdCategorie(): ?Categorie
    {
        return $this->id_categorie;
    }

    public function setIdCategorie(?Categorie $id_categorie): self
    {
        $this->id_categorie = $id_categorie;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setIdProduit($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getIdProduit() === $this) {
                $image->setIdProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Materiel>
     */
    public function getIdMateriel(): Collection
    {
        return $this->id_materiel;
    }

    public function addIdMateriel(Materiel $idMateriel): self
    {
        if (!$this->id_materiel->contains($idMateriel)) {
            $this->id_materiel->add($idMateriel);
        }

        return $this;
    }

    public function removeIdMateriel(Materiel $idMateriel): self
    {
        $this->id_materiel->removeElement($idMateriel);

        return $this;
    }
}
