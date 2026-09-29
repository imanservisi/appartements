<?php

namespace App\Entity;

use App\Entity\Ifi\ValeurDette;
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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nomDette = null;

    /**
     * @var Collection<int, ValeurDette>
     */
    #[ORM\OneToMany(mappedBy: 'emprunt', targetEntity: ValeurDette::class)]
    private Collection $valeurDettes;

    public function __construct()
    {
        $this->interets = new ArrayCollection();
        $this->valeurDettes = new ArrayCollection();
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

    public function getNomDette(): ?string
    {
        return $this->nomDette;
    }

    public function setNomDette(?string $nomDette): static
    {
        $this->nomDette = $nomDette;

        return $this;
    }

    /**
     * @return Collection<int, ValeurDette>
     */
    public function getValeurDettes(): Collection
    {
        return $this->valeurDettes;
    }

    public function addValeurDette(ValeurDette $valeurDette): static
    {
        if (!$this->valeurDettes->contains($valeurDette)) {
            $this->valeurDettes->add($valeurDette);
            $valeurDette->setEmprunt($this);
        }

        return $this;
    }

    public function removeValeurDette(ValeurDette $valeurDette): static
    {
        if ($this->valeurDettes->removeElement($valeurDette)) {
            // set the owning side to null (unless already changed)
            if ($valeurDette->getEmprunt() === $this) {
                $valeurDette->setEmprunt(null);
            }
        }

        return $this;
    }
}
