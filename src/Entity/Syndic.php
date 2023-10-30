<?php

namespace App\Entity;

use App\Repository\SyndicRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SyndicRepository::class)]
class Syndic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nomSyndic = null;

    #[ORM\Column(length: 255)]
    private ?string $adresseSyndic = null;

    #[ORM\OneToMany(mappedBy: 'syndic', targetEntity: MandatSyndic::class)]
    private Collection $mandatSyndic;

    public function __construct()
    {
        $this->mandatSyndic = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSyndic(): ?string
    {
        return $this->nomSyndic;
    }

    public function setNomSyndic(string $nomSyndic): static
    {
        $this->nomSyndic = $nomSyndic;

        return $this;
    }

    public function getAdresseSyndic(): ?string
    {
        return $this->adresseSyndic;
    }

    public function setAdresseSyndic(string $adresseSyndic): static
    {
        $this->adresseSyndic = $adresseSyndic;

        return $this;
    }

    /**
     * @return Collection<int, MandatSyndic>
     */
    public function getMandatSyndic(): Collection
    {
        return $this->mandatSyndic;
    }

    public function addMandatSyndic(MandatSyndic $mandatSyndic): static
    {
        if (!$this->mandatSyndic->contains($mandatSyndic)) {
            $this->mandatSyndic->add($mandatSyndic);
            $mandatSyndic->setSyndic($this);
        }

        return $this;
    }

    public function removeMandatSyndic(MandatSyndic $mandatSyndic): static
    {
        if ($this->mandatSyndic->removeElement($mandatSyndic)) {
            // set the owning side to null (unless already changed)
            if ($mandatSyndic->getSyndic() === $this) {
                $mandatSyndic->setSyndic(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNomSyndic();
    }
}
