<?php

namespace App\Entity;

use App\Repository\EmpruntRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmpruntRepository::class)]
class Emprunt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $debutEmprunt = null;

    #[ORM\ManyToOne(inversedBy: 'emprunts')]
    private ?Banque $banque = null;

    #[ORM\ManyToOne(inversedBy: 'emprunts')]
    private ?Lot $lot = null;

    #[ORM\OneToMany(mappedBy: 'emprunt', targetEntity: Interet::class)]
    private Collection $interets;

    public function __construct()
    {
        $this->interets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDebutEmprunt(): ?\DateTimeInterface
    {
        return $this->debutEmprunt;
    }

    public function setDebutEmprunt(?\DateTimeInterface $debutEmprunt): static
    {
        $this->debutEmprunt = $debutEmprunt;

        return $this;
    }

    public function getBanque(): ?Banque
    {
        return $this->banque;
    }

    public function setBanque(?Banque $banque): static
    {
        $this->banque = $banque;

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
     * @return Collection<int, Interet>
     */
    public function getInterets(): Collection
    {
        return $this->interets;
    }

    public function addInteret(Interet $interet): static
    {
        if (!$this->interets->contains($interet)) {
            $this->interets->add($interet);
            $interet->setEmprunt($this);
        }

        return $this;
    }

    public function removeInteret(Interet $interet): static
    {
        if ($this->interets->removeElement($interet)) {
            // set the owning side to null (unless already changed)
            if ($interet->getEmprunt() === $this) {
                $interet->setEmprunt(null);
            }
        }

        return $this;
    }
}
