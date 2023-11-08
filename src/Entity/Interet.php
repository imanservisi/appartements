<?php

namespace App\Entity;

use App\Repository\InteretRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InteretRepository::class)]
class Interet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $annee = null;

    #[ORM\Column]
    private ?float $montantInteret = null;

    #[ORM\ManyToOne(inversedBy: 'interets')]
    private ?Emprunt $emprunt = null;

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

    public function getMontantInteret(): ?float
    {
        return $this->montantInteret;
    }

    public function setMontantInteret(float $montantInteret): static
    {
        $this->montantInteret = $montantInteret;

        return $this;
    }

    public function getEmprunt(): ?Emprunt
    {
        return $this->emprunt;
    }

    public function setEmprunt(?Emprunt $emprunt): static
    {
        $this->emprunt = $emprunt;

        return $this;
    }
}
