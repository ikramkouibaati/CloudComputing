<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_contact = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $sujet = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $texte = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: 'contacts')]
    #[ORM\JoinColumn(name: 'id_client', referencedColumnName: 'id_utilisateur', nullable: false)]
    private ?Utilisateur $id_client = null;



    public function getIdContact(): ?int
    {
        return $this->id_contact;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet): self
    {
        $this->sujet = $sujet;

        return $this;
    }

    public function getTexte(): ?string
    {
        return $this->texte;
    }

    public function setTexte(string $texte): self
    {
        $this->texte = $texte;

        return $this;
    }

    public function getIdClient(): ?Utilisateur
    {
        return $this->id_client;
    }

    public function setIdClient(?Utilisateur $id_utilisateur): self
    {
        $this->id_client = $id_utilisateur;

        return $this;
    }

    public function serialize()
    {
        return [
            'id_contact' => $this->getIdContact(),
            'email' => $this->getEmail(),
            'sujet' => $this->getSujet(),
            'texte' => $this->getTexte(),
            'id_client' => $this->getIdClient()->getIdUtilisateur(),
        ];
    }
}
