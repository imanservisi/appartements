<?php

namespace App\Entity;

use App\Repository\ResidenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResidenceRepository::class)]
class Residence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nomResidence = null;

    #[ORM\Column(length: 255)]
    private ?string $addresse = null;

    #[ORM\OneToMany(mappedBy: 'residence', targetEntity: Lot::class)]
    private Collection $lot;

    #[ORM\OneToMany(mappedBy: 'residence', targetEntity: MandatSyndic::class)]
    private Collection $mandatSyndics;

    #[ORM\OneToMany(mappedBy: 'residence', targetEntity: TaxeFonciere::class)]
    private Collection $taxeFoncieres;

    #[ORM\OneToOne(mappedBy: 'residence', cascade: ['persist', 'remove'])]
    private ?RegularisationPonctuelle $regularisationPonctuelle = null;

    public function __construct()
    {
        $this->lot = new ArrayCollection();
        $this->mandatSyndics = new ArrayCollection();
        $this->taxeFoncieres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomResidence(): ?string
    {
        return $this->nomResidence;
    }

    public function setNomResidence(string $nomResidence): static
    {
        $this->nomResidence = $nomResidence;

        return $this;
    }

    public function getAddresse(): ?string
    {
        return $this->addresse;
    }

    public function setAddresse(string $addresse): static
    {
        $this->addresse = $addresse;

        return $this;
    }

    /**
     * @return Collection<int, Lot>
     */
    public function getLot(): Collection
    {
        return $this->lot;
    }

    public function addLot(Lot $lot): static
    {
        if (!$this->lot->contains($lot)) {
            $this->lot->add($lot);
            $lot->setResidence($this);
        }

        return $this;
    }

    public function removeLot(Lot $lot): static
    {
        if ($this->lot->removeElement($lot)) {
            // set the owning side to null (unless already changed)
            if ($lot->getResidence() === $this) {
                $lot->setResidence(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MandatSyndic>
     */
    public function getMandatSyndics(): Collection
    {
        return $this->mandatSyndics;
    }

    public function addMandatSyndic(MandatSyndic $mandatSyndic): static
    {
        if (!$this->mandatSyndics->contains($mandatSyndic)) {
            $this->mandatSyndics->add($mandatSyndic);
            $mandatSyndic->setResidence($this);
        }

        return $this;
    }

    public function removeMandatSyndic(MandatSyndic $mandatSyndic): static
    {
        if ($this->mandatSyndics->removeElement($mandatSyndic)) {
            // set the owning side to null (unless already changed)
            if ($mandatSyndic->getResidence() === $this) {
                $mandatSyndic->setResidence(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TaxeFonciere>
     */
    public function getTaxeFoncieres(): Collection
    {
        return $this->taxeFoncieres;
    }

    public function addTaxeFonciere(TaxeFonciere $taxeFonciere): static
    {
        if (!$this->taxeFoncieres->contains($taxeFonciere)) {
            $this->taxeFoncieres->add($taxeFonciere);
            $taxeFonciere->setResidence($this);
        }

        return $this;
    }

    public function removeTaxeFonciere(TaxeFonciere $taxeFonciere): static
    {
        if ($this->taxeFoncieres->removeElement($taxeFonciere)) {
            // set the owning side to null (unless already changed)
            if ($taxeFonciere->getResidence() === $this) {
                $taxeFonciere->setResidence(null);
            }
        }

        return $this;
    }

    public function getRegularisationPonctuelle(): ?RegularisationPonctuelle
    {
        return $this->regularisationPonctuelle;
    }

    public function setRegularisationPonctuelle(?RegularisationPonctuelle $regularisationPonctuelle): static
    {
        // unset the owning side of the relation if necessary
        if ($regularisationPonctuelle === null && $this->regularisationPonctuelle !== null) {
            $this->regularisationPonctuelle->setResidence(null);
        }

        // set the owning side of the relation if necessary
        if ($regularisationPonctuelle !== null && $regularisationPonctuelle->getResidence() !== $this) {
            $regularisationPonctuelle->setResidence($this);
        }

        $this->regularisationPonctuelle = $regularisationPonctuelle;

        return $this;
    }
}
