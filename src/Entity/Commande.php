<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"show_product"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show_product"})
     */
    private $nomCommande;

    /**
     * @ORM\Column(type="date")
     * @Groups({"show_product"})
     */
    private $date;

    /**
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
     */
    private $operation;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commande")
     * @Groups({"show_product"})
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCommande(): ?string
    {
        return $this->nomCommande;
    }

    public function setNomCommande(string $nomCommande): self
    {
        $this->nomCommande = $nomCommande;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
