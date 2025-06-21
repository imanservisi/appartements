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

    #[ORM\OneToMany(mappedBy: 'residence', targetEntity: RegularisationPonctuelle::class)]
    private Collection $regularisationPonctuelles;

    #[ORM\OneToMany(mappedBy: 'residence', targetEntity: Recapitulatif::class)]
    private Collection $recapitulatifs;

    public function __construct()
    {
        $this->lot = new ArrayCollection();
        $this->mandatSyndics = new ArrayCollection();
        $this->taxeFoncieres = new ArrayCollection();
        $this->regularisationPonctuelles = new ArrayCollection();
        $this->recapitulatifs = new ArrayCollection();
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

    /**
     * @return Collection<int, RegularisationPonctuelle>
     */
    public function getRegularisationPonctuelles(): Collection
    {
        return $this->regularisationPonctuelles;
    }

    public function addRegularisationPonctuelle(RegularisationPonctuelle $regularisationPonctuelle): static
    {
        if (!$this->regularisationPonctuelles->contains($regularisationPonctuelle)) {
            $this->regularisationPonctuelles->add($regularisationPonctuelle);
            $regularisationPonctuelle->setResidence($this);
        }

        return $this;
    }

    public function removeRegularisationPonctuelle(RegularisationPonctuelle $regularisationPonctuelle): static
    {
        if ($this->regularisationPonctuelles->removeElement($regularisationPonctuelle)) {
            // set the owning side to null (unless already changed)
            if ($regularisationPonctuelle->getResidence() === $this) {
                $regularisationPonctuelle->setResidence(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Recapitulatif>
     */
    public function getRecapitulatifs(): Collection
    {
        return $this->recapitulatifs;
    }

    public function addRecapitulatif(Recapitulatif $recapitulatif): static
    {
        if (!$this->recapitulatifs->contains($recapitulatif)) {
            $this->recapitulatifs->add($recapitulatif);
            $recapitulatif->setResidence($this);
        }

        return $this;
    }

    public function removeRecapitulatif(Recapitulatif $recapitulatif): static
    {
        if ($this->recapitulatifs->removeElement($recapitulatif)) {
            // set the owning side to null (unless already changed)
            if ($recapitulatif->getResidence() === $this) {
                $recapitulatif->setResidence(null);
            }
        }

        return $this;
    }
}
