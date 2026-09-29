<?php

namespace App\Entity\Ifi;

use App\Repository\Ifi\TaxeFonciereIfiRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaxeFonciereIfiRepository::class)]
class TaxeFonciereIfi
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $valeur = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $date = null;

    #[ORM\Column(length: 4, nullable: true)]
    private ?string $annee = null;

    #[ORM\Column(length: 255)]
    private ?string $nomTFI = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValeur(): ?int
    {
        return $this->valeur;
    }

    public function setValeur(int $valeur): static
    {
        $this->valeur = $valeur;

        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(?\DateTime $date): static
    {
        $this->date = $date;

        return $this;
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

    public function getNomTFI(): ?string
    {
        return $this->nomTFI;
    }

    public function setNomTFI(string $nomTFI): static
    {
        $this->nomTFI = $nomTFI;

        return $this;
    }
}
