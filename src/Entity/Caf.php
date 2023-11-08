<?php

namespace App\Entity;

use App\Repository\CafRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CafRepository::class)]
class Caf
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $annee = null;

    #[ORM\Column(length: 255)]
    private ?string $mois = null;

    #[ORM\Column(nullable: true)]
    private ?float $montantCaf = null;

    #[ORM\ManyToOne(inversedBy: 'cafs')]
    private ?Location $location = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMois(): ?string
    {
        return $this->mois;
    }

    public function setMois(string $mois): static
    {
        $this->mois = $mois;

        return $this;
    }

    public function getMontantCaf(): ?float
    {
        return $this->montantCaf;
    }

    public function setMontantCaf(?float $montantCaf): static
    {
        $this->montantCaf = $montantCaf;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): static
    {
        $this->location = $location;

        return $this;
    }
}
