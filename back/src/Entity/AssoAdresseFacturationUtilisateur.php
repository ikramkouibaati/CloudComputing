<?php

// src/Entity/AssoAdresseFacturationUtilisateur.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AssoAdresseFacturationUtilisateurRepository")
 */
class AssoAdresseFacturationUtilisateur
{
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur")
     * @ORM\JoinColumn(name="id_utilisateur", referencedColumnName="id_utilisateur")
     */
    private $utilisateur;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\AdresseFacturation")
     * @ORM\JoinColumn(name="id_adresse_facturation", referencedColumnName="id_adresse_facturation")
     */
    private $adresseFacturation;

    // Getters and setters

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;
        return $this;
    }

    public function getAdresseFacturation(): ?AdresseFacturation
    {
        return $this->adresseFacturation;
    }

    public function setAdresseFacturation(?AdresseFacturation $adresseFacturation): self
    {
        $this->adresseFacturation = $adresseFacturation;
        return $this;
    }
}
