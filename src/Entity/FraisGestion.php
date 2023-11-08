<?php

namespace App\Entity;

use App\Repository\FraisGestionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FraisGestionRepository::class)]
class FraisGestion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $annee = null;

    #[ORM\Column(length: 255)]
    private ?string $mois = null;

    #[ORM\Column]
    private ?float $montant = null;

    #[ORM\ManyToOne(inversedBy: 'fraisGestions')]
    private ?MandatGestionnaire $mandatGestionnaire = null;

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

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getMandatGestionnaire(): ?MandatGestionnaire
    {
        return $this->mandatGestionnaire;
    }

    public function setMandatGestionnaire(?MandatGestionnaire $mandatGestionnaire): static
    {
        $this->mandatGestionnaire = $mandatGestionnaire;

        return $this;
    }
}
