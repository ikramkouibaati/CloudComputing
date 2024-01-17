<?php

namespace App\Entity;

use App\Entity\Role;
use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["default"])]
    private ?int $id_utilisateur = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $mot_de_passe = null;

    #[ORM\Column(length: 20)]
    private ?string $telephone = null;

    #[ORM\ManyToOne(inversedBy: 'utilisateurs')]
    #[ORM\JoinColumn(name: "id_role", nullable: false)]
    private ?Role $id_role = null;

    #[ORM\OneToMany(mappedBy: 'id_client', targetEntity: Contact::class)]
    private Collection $contacts;

    #[ORM\ManyToMany(mappedBy: 'id_utilisateur', targetEntity: ModePaiement::class)]
    #[ORM\JoinTable(name: 'asso_utilisateur_paiement')]
    #[ORM\JoinColumn(name: 'id_utilisateur', referencedColumnName: 'id_utilisateur')]
    #[ORM\InverseJoinColumn(name: 'id_mode_paiement', referencedColumnName: 'id_mode_paiement')]
    private Collection $modePaiements;

    #[ORM\OneToMany(mappedBy: 'id_utilisateur', targetEntity: Commande::class)]
    private Collection $commandes;

    #[ORM\ManyToMany(targetEntity: AdresseLivraison::class, inversedBy: 'utilisateurs')]
    #[ORM\JoinTable(name: 'asso_adresse_livraison_utilisateur')]
    #[ORM\JoinColumn(name: 'id_utilisateur', referencedColumnName: 'id_utilisateur')]
    #[ORM\InverseJoinColumn(name: 'id_adresse_livraison', referencedColumnName: 'id_adresse_livraison')]
    private Collection $adresses_livraison;

    #[ORM\ManyToMany(targetEntity: AdresseFacturation::class, inversedBy: 'utilisateurs')]
    #[ORM\JoinTable(name: 'asso_adresse_facturation_utilisateur')]
    #[ORM\JoinColumn(name: 'id_utilisateur', referencedColumnName: 'id_utilisateur')]
    #[ORM\InverseJoinColumn(name: 'id_adresse_facturation', referencedColumnName: 'id_adresse_facturation')]
    private Collection $adresses_facturation;


// Ajoutez ces lignes à la classe Utilisateur

#[ORM\Column(length: 255, nullable: true)]
private ?string $token = null;

public function getToken(): ?string
{
    return $this->token;
}

public function setToken(?string $token): self
{
    $this->token = $token;
    return $this;
}




    public function __construct()
    {
        $this->contacts = new ArrayCollection();
        $this->modePaiements = new ArrayCollection();
        $this->commandes = new ArrayCollection();
        $this->adresses_livraison = new ArrayCollection();
        $this->adresses_facturation = new ArrayCollection();
    }

    public function getIdUtilisateur(): ?int
    {
        return $this->id_utilisateur;
    }

    public function setIdUtilisateur(int $id_utilisateur): self
    {
        $this->id_utilisateur = $id_utilisateur;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
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

    public function getMotDePasse(): ?string
    {
        return $this->mot_de_passe;
    }

    public function setMotDePasse(string $mot_de_passe): self
    {
        $this->mot_de_passe = $mot_de_passe;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getIdRole(): ?Role
    {
        return $this->id_role;
    }

    public function setIdRole(?Role $id_role): self
    {
        $this->id_role = $id_role;

        return $this;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
            $contact->setIdClient($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getIdClient() === $this) {
                $contact->setIdClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ModePaiement>
     */
    public function getmodePaiements(): Collection
    {
        return $this->modePaiements;
    }

    public function addModePaiement(ModePaiement $ModePaiement): self
    {
        if (!$this->modePaiements->contains($ModePaiement)) {
            $this->modePaiements->add($ModePaiement);
            $ModePaiement->addIdUtilisateur($this);
        }

        return $this;
    }

    public function removeModePaiement(ModePaiement $ModePaiement): self
    {
        if ($this->modePaiements->removeElement($ModePaiement)) {
            $ModePaiement->removeIdUtilisateur($this);
        }

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
            $commande->setIdUtilisateur($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getIdUtilisateur() === $this) {
                $commande->setIdUtilisateur(null);
            }
        }

        return $this;
    }

   /* public function serialize()
    {
        $serializedContacts = [];

        foreach ($this->contacts as $contact) {
            $serializedContacts[] = $contact->serialize();
        }

        return [
            'id_utilisateur' => $this->getIdUtilisateur(),
            'nom' => $this->getNom(),
            'prenom' => $this->getPrenom(),
            'email' => $this->getEmail(),
            'mot_de_passe' => $this->getMotDePasse(),
            'telephone' => $this->getTelephone(),
            'contacts' => $serializedContacts,
        ];
    }
*/

public function serialize()
{
    $serializedContacts = [];

    foreach ($this->contacts as $contact) {
        $serializedContacts[] = $contact->serialize();
    }

    // Retrieve the associated addresses
    $adressesLivraison = $this->getAdressesLivraison();
    $adressesFacturation = $this->getAdressesFacturation();

    // Retrieve the associated commands
    $commands = $this->getCommandes();

    // Include the relevant address information in the serialization
    $serializedData = [
        'id_utilisateur' => $this->getIdUtilisateur(),
        'nom' => $this->getNom(),
        'prenom' => $this->getPrenom(),
        'email' => $this->getEmail(),
        'mot_de_passe' => $this->getMotDePasse(),
        'telephone' => $this->getTelephone(),
        'contacts' => $serializedContacts,
        'adresses_livraison' => [],
        'adresses_facturation' => [],
        'commandes' => [],
    ];

    // Include adresses_livraison if available
    foreach ($adressesLivraison as $adresseLivraison) {
        $serializedData['adresses_livraison'][] = [
            'rue' => $adresseLivraison->getRue(),
            'complement_adresse' => $adresseLivraison->getComplementAdresse(),
            'region' => $adresseLivraison->getRegion(),
            'ville' => $adresseLivraison->getVille(),
            'code_postal' => $adresseLivraison->getCodePostal(),
            'pays' => $adresseLivraison->getPays(),
        ];
    }

    // Include adresses_facturation if available
    foreach ($adressesFacturation as $adresseFacturation) {
        $serializedData['adresses_facturation'][] = [
            'rue' => $adresseFacturation->getRue(),
            'complement_adresse' => $adresseFacturation->getComplementAdresse(),
            'region' => $adresseFacturation->getRegion(),
            'ville' => $adresseFacturation->getVille(),
            'code_postal' => $adresseFacturation->getCodePostal(),
            'pays' => $adresseFacturation->getPays(),
        ];
    }

    // Include commands if available
    foreach ($commands as $command) {
        $serializedData['commandes'][] = [
            'id_commande' => $command->getIdCommande(),
            // Include other relevant information from the Commande entity
        ];
    }

    return $serializedData;
}





    /**
     * @return Collection<int, AdresseLivraison>
     */
    public function getAdressesLivraison(): Collection
    {
        return $this->adresses_livraison;
    }

    public function addAdressesLivraison(AdresseLivraison $adressesLivraison): self
    {
        if (!$this->adresses_livraison->contains($adressesLivraison)) {
            $this->adresses_livraison->add($adressesLivraison);
        }

        return $this;
    }

    public function removeAdressesLivraison(AdresseLivraison $adressesLivraison): self
    {
        $this->adresses_livraison->removeElement($adressesLivraison);

        return $this;
    }

    /**
     * @return Collection<int, AdresseFacturation>
     */
    public function getAdressesFacturation(): Collection
    {
        return $this->adresses_facturation;
    }

    public function addAdressesFacturation(AdresseFacturation $adressesFacturation): self
    {
        if (!$this->adresses_facturation->contains($adressesFacturation)) {
            $this->adresses_facturation->add($adressesFacturation);
        }

        return $this;
    }

    public function removeAdressesFacturation(AdresseFacturation $adressesFacturation): self
    {
        $this->adresses_facturation->removeElement($adressesFacturation);

        return $this;
    }
}
