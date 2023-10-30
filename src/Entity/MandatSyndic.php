<?php

namespace App\Entity;

use App\Repository\MandatSyndicRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MandatSyndicRepository::class)]
class MandatSyndic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $debutMandat = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $finMandat = null;

    #[ORM\ManyToOne(inversedBy: 'mandatSyndics')]
    private ?Residence $residence = null;

    #[ORM\ManyToOne(inversedBy: 'mandatSyndic')]
    private ?Syndic $syndic = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDebutMandat(): ?\DateTimeInterface
    {
        return $this->debutMandat;
    }

    public function setDebutMandat(?\DateTimeInterface $debutMandat): static
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

    public function getResidence(): ?Residence
    {
        return $this->residence;
    }

    public function setResidence(?Residence $residence): static
    {
        $this->residence = $residence;

        return $this;
    }

    public function getSyndic(): ?Syndic
    {
        return $this->syndic;
    }

    public function setSyndic(?Syndic $syndic): static
    {
        $this->syndic = $syndic;

        return $this;
    }
}
