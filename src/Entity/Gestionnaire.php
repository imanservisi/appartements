<?php

namespace App\Entity;

use App\Repository\GestionnaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GestionnaireRepository::class)]
class Gestionnaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomGestionnaire = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresseGestionnaire = null;

    #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: MandatGestionnaire::class)]
    private Collection $mandatGestion;

    public function __construct()
    {
        $this->mandatGestion = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomGestionnaire(): ?string
    {
        return $this->nomGestionnaire;
    }

    public function setNomGestionnaire(string $nomGestionnaire): static
    {
        $this->nomGestionnaire = $nomGestionnaire;

        return $this;
    }

    public function getAdresseGestionnaire(): ?string
    {
        return $this->adresseGestionnaire;
    }

    public function setAdresseGestionnaire(?string $adresseGestionnaire): static
    {
        $this->adresseGestionnaire = $adresseGestionnaire;

        return $this;
    }

    /**
     * @return Collection<int, MandatGestionnaire>
     */
    public function getMandatGestion(): Collection
    {
        return $this->mandatGestion;
    }

    public function addMandatGestion(MandatGestionnaire $mandatGestion): static
    {
        if (!$this->mandatGestion->contains($mandatGestion)) {
            $this->mandatGestion->add($mandatGestion);
            $mandatGestion->setGestionnaire($this);
        }

        return $this;
    }

    public function removeMandatGestion(MandatGestionnaire $mandatGestion): static
    {
        if ($this->mandatGestion->removeElement($mandatGestion)) {
            // set the owning side to null (unless already changed)
            if ($mandatGestion->getGestionnaire() === $this) {
                $mandatGestion->setGestionnaire(null);
            }
        }

        return $this;
    }
}
