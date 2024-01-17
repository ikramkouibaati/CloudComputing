<?php

namespace App\Entity;

use App\Repository\StatutRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatutRepository::class)]
class Statut
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_statut = null;

    #[ORM\Column(nullable: false)]
    #[ORM\OneToMany(mappedBy: 'statut', targetEntity: Commande::class)]
    private Collection $statut;

    public function __construct()
    {
        $this->statut = new ArrayCollection();
    }

    public function getIdStatut(): ?int
    {
        return $this->id_statut;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getStatut(): Collection
    {
        return $this->statut;
    }

    public function addStatut(Commande $statut): self
    {
        if (!$this->statut->contains($statut)) {
            $this->statut->add($statut);
            $statut->setStatut($this);
        }

        return $this;
    }

    public function removeStatut(Commande $statut): self
    {
        if ($this->statut->removeElement($statut)) {
            // set the owning side to null (unless already changed)
            if ($statut->getStatut() === $this) {
                $statut->setStatut(null);
            }
        }

        return $this;
    }
}
