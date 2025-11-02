<?php

namespace App\Entity;

use App\Repository\RecapitulatifRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecapitulatifRepository::class)]
class Recapitulatif
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $annee = null;

    #[ORM\Column]
    private ?float $totalRecette = null;

    #[ORM\Column]
    private ?float $fraisAdm = null;

    #[ORM\Column]
    private ?float $autresFrais = null;

    #[ORM\Column]
    private ?float $primesAssurances = null;

    #[ORM\Column]
    private ?float $travaux = null;

    #[ORM\Column]
    private ?float $taxeFonciere = null;

    #[ORM\Column]
    private ?float $provisionPourCharge = null;

    #[ORM\Column(nullable: true)]
    private ?float $interetEmprunt = null;

    #[ORM\Column(nullable: true)]
    private ?float $montant261 = null;

    #[ORM\Column(nullable: true)]
    private ?float $montant229bis = null;

    #[ORM\Column(nullable: true)]
    private ?float $montant230 = null;

    #[ORM\Column(nullable: true)]
    private ?float $montant230bis = null;

    #[ORM\ManyToOne(inversedBy: 'recapitulatifs')]
    private ?Residence $residence = null;

    #[ORM\Column(nullable: true)]
    private ?float $loyer = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTime $updatedAt = null;

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

    public function getTotalRecette(): ?float
    {
        return $this->totalRecette;
    }

    public function setTotalRecette(float $totalRecette): static
    {
        $this->totalRecette = $totalRecette;

        return $this;
    }

    public function getFraisAdm(): ?float
    {
        return $this->fraisAdm;
    }

    public function setFraisAdm(float $fraisAdm): static
    {
        $this->fraisAdm = $fraisAdm;

        return $this;
    }

    public function getAutresFrais(): ?float
    {
        return $this->autresFrais;
    }

    public function setAutresFrais(float $autresFrais): static
    {
        $this->autresFrais = $autresFrais;

        return $this;
    }

    public function getPrimesAssurances(): ?float
    {
        return $this->primesAssurances;
    }

    public function setPrimesAssurances(float $primesAssurances): static
    {
        $this->primesAssurances = $primesAssurances;

        return $this;
    }

    public function getTravaux(): ?float
    {
        return $this->travaux;
    }

    public function setTravaux(float $travaux): static
    {
        $this->travaux = $travaux;

        return $this;
    }

    public function getTaxeFonciere(): ?float
    {
        return $this->taxeFonciere;
    }

    public function setTaxeFonciere(float $taxeFonciere): static
    {
        $this->taxeFonciere = $taxeFonciere;

        return $this;
    }

    public function getProvisionPourCharge(): ?float
    {
        return $this->provisionPourCharge;
    }

    public function setProvisionPourCharge(float $provisionPourCharge): static
    {
        $this->provisionPourCharge = $provisionPourCharge;

        return $this;
    }

    public function getInteretEmprunt(): ?float
    {
        return $this->interetEmprunt;
    }

    public function setInteretEmprunt(?float $interetEmprunt): static
    {
        $this->interetEmprunt = $interetEmprunt;

        return $this;
    }

    public function getMontant261(): ?float
    {
        return $this->montant261;
    }

    public function setMontant261(?float $montant261): static
    {
        $this->montant261 = $montant261;

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

    public function getLoyer(): ?float
    {
        return $this->loyer;
    }

    public function setLoyer(?float $loyer): static
    {
        $this->loyer = $loyer;

        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
