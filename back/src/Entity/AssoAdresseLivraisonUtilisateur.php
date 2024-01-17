<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AssoAdresseLivraisonUtilisateurRepository")
 */
class AssoAdresseLivraisonUtilisateur
{
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur")
     * @ORM\JoinColumn(name="id_utilisateur", referencedColumnName="id_utilisateur")
     */
    private $utilisateur;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\AdresseLivraison")
     * @ORM\JoinColumn(name="id_adresse_livraison", referencedColumnName="id_adresse_livraison")
     */
    private $adresseLivraison;

    // Getters and setters (if needed)

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;
        return $this;
    }

    public function getAdresseLivraison(): ?AdresseLivraison
    {
        return $this->adresseLivraison;
    }

    public function setAdresseLivraison(?AdresseLivraison $adresseLivraison): self
    {
        $this->adresseLivraison = $adresseLivraison;
        return $this;
    }
}
