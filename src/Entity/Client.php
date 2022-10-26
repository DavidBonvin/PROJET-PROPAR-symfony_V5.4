<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
<<<<<<< HEAD
=======
use Symfony\Component\Serializer\Annotation\Groups;
>>>>>>> 4f3f0cdcae019a613b63dff542d03f37766f324d

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
<<<<<<< HEAD
=======
     * @Groups({"show_product"})
>>>>>>> 4f3f0cdcae019a613b63dff542d03f37766f324d
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
<<<<<<< HEAD
    private $Prenom;
=======
    private $prenom;
>>>>>>> 4f3f0cdcae019a613b63dff542d03f37766f324d

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
<<<<<<< HEAD
    private $Adresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
=======
    private $nomSociete;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
>>>>>>> 4f3f0cdcae019a613b63dff542d03f37766f324d
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity=Commande::class, mappedBy="client")
     */
    private $commandes;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
<<<<<<< HEAD
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;
=======
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNomSociete(): ?string
    {
        return $this->nomSociete;
    }

    public function setNomSociete(string $nomSociete): self
    {
        $this->nomSociete = $nomSociete;
>>>>>>> 4f3f0cdcae019a613b63dff542d03f37766f324d

        return $this;
    }

    public function getAdresse(): ?string
    {
<<<<<<< HEAD
        return $this->Adresse;
    }

    public function setAdresse(?string $Adresse): self
    {
        $this->Adresse = $Adresse;
=======
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;
>>>>>>> 4f3f0cdcae019a613b63dff542d03f37766f324d

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

<<<<<<< HEAD
    public function setEmail(?string $email): self
=======
    public function setEmail(string $email): self
>>>>>>> 4f3f0cdcae019a613b63dff542d03f37766f324d
    {
        $this->email = $email;

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
            $this->commandes[] = $commande;
            $commande->setClient($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getClient() === $this) {
                $commande->setClient(null);
            }
        }

        return $this;
    }
}
