<?php

namespace App\Entity;

use App\Repository\MandatGestionnaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\ManyToOne(inversedBy: 'mandatGestion')]
    private ?Gestionnaire $gestionnaire = null;

    #[ORM\OneToMany(mappedBy: 'mandatGestionnaire', targetEntity: FraisGestion::class)]
    private Collection $fraisGestions;

    public function __construct()
    {
        $this->fraisGestions = new ArrayCollection();
    }

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

    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): static
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }

    /**
     * @return Collection<int, FraisGestion>
     */
    public function getFraisGestions(): Collection
    {
        return $this->fraisGestions;
    }

    public function addFraisGestion(FraisGestion $fraisGestion): static
    {
        if (!$this->fraisGestions->contains($fraisGestion)) {
            $this->fraisGestions->add($fraisGestion);
            $fraisGestion->setMandatGestionnaire($this);
        }

        return $this;
    }

    public function removeFraisGestion(FraisGestion $fraisGestion): static
    {
        if ($this->fraisGestions->removeElement($fraisGestion)) {
            // set the owning side to null (unless already changed)
            if ($fraisGestion->getMandatGestionnaire() === $this) {
                $fraisGestion->setMandatGestionnaire(null);
            }
        }

        return $this;
    }
}
