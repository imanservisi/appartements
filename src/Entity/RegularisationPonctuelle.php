<?php

namespace App\Entity;

use App\Repository\RegularisationPonctuelleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegularisationPonctuelleRepository::class)]
class RegularisationPonctuelle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $annee = null;

    #[ORM\Column(nullable: true)]
    private ?float $montant229bis = null;

    #[ORM\Column(nullable: true)]
    private ?float $montant230 = null;

    #[ORM\Column(nullable: true)]
    private ?float $montant230bis = null;

    #[ORM\ManyToOne(inversedBy: 'regularisationPonctuelles')]
    private ?Residence $residence = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnnee(): ?string
    {
        return $this->annee;
    }

    public function setAnnee(?string $annee): static
    {
        $this->annee = $annee;

        return $this;
    }

    public function getMontant229bis(): ?float
    {
        return $this->montant229bis;
    }

    public function setMontant229bis(?float $montant229bis): static
    {
        $this->montant229bis = $montant229bis;

        return $this;
    }

    public function getMontant230(): ?float
    {
        return $this->montant230;
    }

    public function setMontant230(?float $montant230): static
    {
        $this->montant230 = $montant230;

        return $this;
    }

    public function getMontant230bis(): ?float
    {
        return $this->montant230bis;
    }

    public function setMontant230bis(?float $montant230bis): static
    {
        $this->montant230bis = $montant230bis;

        return $this;
    }

    public function getResidence(): ?Residence
    {
        return $this->residence;
    }

    public function setResidence(?Residence $residence): static
    {
        $this->residence = $residence;

        return $this;
    }
}
