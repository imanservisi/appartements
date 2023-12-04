<?php

namespace App\Entity;

use App\Repository\TravauxRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TravauxRepository::class)]
class Travaux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateTravaux = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $typeTravaux = null;

    #[ORM\Column]
    private ?float $montantTravaux = null;

    #[ORM\ManyToOne(inversedBy: 'travauxes')]
    private ?Lot $lot = null;

    #[ORM\ManyToOne(inversedBy: 'travauxes')]
    private ?Entreprise $entreprise = null;

    #[ORM\Column(length: 5)]
    private ?string $annee = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateTravaux(): ?\DateTimeInterface
    {
        return $this->dateTravaux;
    }

    public function setDateTravaux(\DateTimeInterface $dateTravaux): static
    {
        $this->dateTravaux = $dateTravaux;

        return $this;
    }

    public function getTypeTravaux(): ?string
    {
        return $this->typeTravaux;
    }

    public function setTypeTravaux(?string $typeTravaux): static
    {
        $this->typeTravaux = $typeTravaux;

        return $this;
    }

    public function getMontantTravaux(): ?float
    {
        return $this->montantTravaux;
    }

    public function setMontantTravaux(float $montantTravaux): static
    {
        $this->montantTravaux = $montantTravaux;

        return $this;
    }

    public function getLot(): ?Lot
    {
        return $this->lot;
    }

    public function setLot(?Lot $lot): static
    {
        $this->lot = $lot;

        return $this;
    }

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): static
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getAnnee(): ?string
    {
        return $this->annee;
    }

    public function setAnnee(string $annee): static
    {
        $this->annee = $annee;

        return $this;
    }
}
