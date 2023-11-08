<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $debutLocation = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $finLocation = null;

    #[ORM\ManyToOne(inversedBy: 'locations')]
    private ?Lot $lot = null;

    #[ORM\OneToMany(mappedBy: 'location', targetEntity: Caf::class)]
    private Collection $cafs;

    #[ORM\OneToMany(mappedBy: 'location', targetEntity: Loyer::class)]
    private Collection $loyers;

    #[ORM\ManyToOne(inversedBy: 'locations')]
    private ?Locataire $locataire = null;

    public function __construct()
    {
        $this->cafs = new ArrayCollection();
        $this->loyers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDebutLocation(): ?\DateTimeInterface
    {
        return $this->debutLocation;
    }

    public function setDebutLocation(\DateTimeInterface $debutLocation): static
    {
        $this->debutLocation = $debutLocation;

        return $this;
    }

    public function getFinLocation(): ?\DateTimeInterface
    {
        return $this->finLocation;
    }

    public function setFinLocation(?\DateTimeInterface $finLocation): static
    {
        $this->finLocation = $finLocation;

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

    /**
     * @return Collection<int, Caf>
     */
    public function getCafs(): Collection
    {
        return $this->cafs;
    }

    public function addCaf(Caf $caf): static
    {
        if (!$this->cafs->contains($caf)) {
            $this->cafs->add($caf);
            $caf->setLocation($this);
        }

        return $this;
    }

    public function removeCaf(Caf $caf): static
    {
        if ($this->cafs->removeElement($caf)) {
            // set the owning side to null (unless already changed)
            if ($caf->getLocation() === $this) {
                $caf->setLocation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Loyer>
     */
    public function getLoyers(): Collection
    {
        return $this->loyers;
    }

    public function addLoyer(Loyer $loyer): static
    {
        if (!$this->loyers->contains($loyer)) {
            $this->loyers->add($loyer);
            $loyer->setLocation($this);
        }

        return $this;
    }

    public function removeLoyer(Loyer $loyer): static
    {
        if ($this->loyers->removeElement($loyer)) {
            // set the owning side to null (unless already changed)
            if ($loyer->getLocation() === $this) {
                $loyer->setLocation(null);
            }
        }

        return $this;
    }

    public function getLocataire(): ?Locataire
    {
        return $this->locataire;
    }

    public function setLocataire(?Locataire $locataire): static
    {
        $this->locataire = $locataire;

        return $this;
    }
}
