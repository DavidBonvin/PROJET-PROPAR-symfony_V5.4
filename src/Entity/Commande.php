<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping as ORM;
<<<<<<< HEAD
=======
use Symfony\Component\Serializer\Annotation\Groups;
>>>>>>> 4f3f0cdcae019a613b63dff542d03f37766f324d

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
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
<<<<<<< HEAD
     * @ORM\Column(type="datetime", nullable=true)
=======
     * @ORM\Column(type="string", length=255)
     * @Groups({"show_product"})
     */
    private $nomCommande;

    /**
     * @ORM\Column(type="date")
     * @Groups({"show_product"})
>>>>>>> 4f3f0cdcae019a613b63dff542d03f37766f324d
     */
    private $date;

    /**
<<<<<<< HEAD
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Statut;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $facture;

    /**
     * @ORM\ManyToOne(targetEntity=Operation::class, inversedBy="commandes")
=======
     * @ORM\Column(type="string", length=255)
     * @Groups({"show_product"})
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="commande")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"show_product"})
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity=Operation::class, inversedBy="commande")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"show_product"})
>>>>>>> 4f3f0cdcae019a613b63dff542d03f37766f324d
     */
    private $operation;

    /**
<<<<<<< HEAD
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="commandes")
     */
    private $client;
=======
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commande")
     * @Groups({"show_product"})
     */
    private $user;
>>>>>>> 4f3f0cdcae019a613b63dff542d03f37766f324d

    public function getId(): ?int
    {
        return $this->id;
    }

<<<<<<< HEAD
=======
    public function getNomCommande(): ?string
    {
        return $this->nomCommande;
    }

    public function setNomCommande(string $nomCommande): self
    {
        $this->nomCommande = $nomCommande;

        return $this;
    }

>>>>>>> 4f3f0cdcae019a613b63dff542d03f37766f324d
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

<<<<<<< HEAD
    public function setDate(?\DateTimeInterface $date): self
=======
    public function setDate(\DateTimeInterface $date): self
>>>>>>> 4f3f0cdcae019a613b63dff542d03f37766f324d
    {
        $this->date = $date;

        return $this;
    }

    public function getStatut(): ?string
    {
<<<<<<< HEAD
        return $this->Statut;
    }

    public function setStatut(?string $Statut): self
    {
        $this->Statut = $Statut;
=======
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;
>>>>>>> 4f3f0cdcae019a613b63dff542d03f37766f324d

        return $this;
    }

<<<<<<< HEAD
    public function getFacture(): ?string
    {
        return $this->facture;
    }

    public function setFacture(?string $facture): self
    {
        $this->facture = $facture;
=======
    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;
>>>>>>> 4f3f0cdcae019a613b63dff542d03f37766f324d

        return $this;
    }

    public function getOperation(): ?Operation
    {
        return $this->operation;
    }

    public function setOperation(?Operation $operation): self
    {
        $this->operation = $operation;

        return $this;
    }

<<<<<<< HEAD
    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;
=======
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
>>>>>>> 4f3f0cdcae019a613b63dff542d03f37766f324d

        return $this;
    }
}
