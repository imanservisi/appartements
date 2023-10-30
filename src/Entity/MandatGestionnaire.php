<?php

namespace App\Entity;

use App\Repository\MandatGestionnaireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MandatGestionnaireRepository::class)]
class MandatGestionnaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $debutMandat = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $finMandat = null;

    #[ORM\ManyToOne(inversedBy: 'mandatGestionnaires')]
    private ?Lot $lot = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDebutMandat(): ?\DateTimeInterface
    {
        return $this->debutMandat;
    }

    public function setDebutMandat(\DateTimeInterface $debutMandat): static
    {
        $this->debutMandat = $debutMandat;

        return $this;
    }

    public function getFinMandat(): ?\DateTimeInterface
    {
        return $this->finMandat;
    }

    public function setFinMandat(?\DateTimeInterface $finMandat): static
    {
        $this->finMandat = $finMandat;

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
}
