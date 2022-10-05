<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Statut;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $facture;

    /**
     * @ORM\ManyToOne(targetEntity=Operation::class, inversedBy="commandes")
     */
    private $operation;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="commandes")
     */
    private $client;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->Statut;
    }

    public function setStatut(?string $Statut): self
    {
        $this->Statut = $Statut;

        return $this;
    }

    public function getFacture(): ?string
    {
        return $this->facture;
    }

    public function setFacture(?string $facture): self
    {
        $this->facture = $facture;

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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
