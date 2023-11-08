<?php

namespace App\Entity;

use App\Repository\LotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LotRepository::class)]
class Lot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nomLot = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateAchat = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateVente = null;

    #[ORM\ManyToOne(inversedBy: 'lot')]
    private ?Residence $residence = null;

    #[ORM\OneToMany(mappedBy: 'lot', targetEntity: Charge::class)]
    private Collection $charges;

    #[ORM\OneToMany(mappedBy: 'lot', targetEntity: PrimeAssurance::class)]
    private Collection $primeAssurances;

    #[ORM\OneToMany(mappedBy: 'lot', targetEntity: MandatGestionnaire::class)]
    private Collection $mandatGestionnaires;

    #[ORM\OneToMany(mappedBy: 'lot', targetEntity: Emprunt::class)]
    private Collection $emprunts;

    #[ORM\OneToMany(mappedBy: 'lot', targetEntity: Travaux::class)]
    private Collection $travauxes;

    #[ORM\OneToMany(mappedBy: 'lot', targetEntity: Location::class)]
    private Collection $locations;

    public function __construct()
    {
        $this->charges = new ArrayCollection();
        $this->primeAssurances = new ArrayCollection();
        $this->mandatGestionnaires = new ArrayCollection();
        $this->emprunts = new ArrayCollection();
        $this->travauxes = new ArrayCollection();
        $this->locations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomLot(): ?string
    {
        return $this->nomLot;
    }

    public function setNomLot(string $nomLot): static
    {
        $this->nomLot = $nomLot;

        return $this;
    }

    public function getDateAchat(): ?\DateTimeInterface
    {
        return $this->dateAchat;
    }

    public function setDateAchat(\DateTimeInterface $dateAchat): static
    {
        $this->dateAchat = $dateAchat;

        return $this;
    }

    public function getDateVente(): ?\DateTimeInterface
    {
        return $this->dateVente;
    }

    public function setDateVente(?\DateTimeInterface $dateVente): static
    {
        $this->dateVente = $dateVente;

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

    /**
     * @return Collection<int, Charge>
     */
    public function getCharges(): Collection
    {
        return $this->charges;
    }

    public function addCharge(Charge $charge): static
    {
        if (!$this->charges->contains($charge)) {
            $this->charges->add($charge);
            $charge->setLot($this);
        }

        return $this;
    }

    public function removeCharge(Charge $charge): static
    {
        if ($this->charges->removeElement($charge)) {
            // set the owning side to null (unless already changed)
            if ($charge->getLot() === $this) {
                $charge->setLot(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PrimeAssurance>
     */
    public function getPrimeAssurances(): Collection
    {
        return $this->primeAssurances;
    }

    public function addPrimeAssurance(PrimeAssurance $primeAssurance): static
    {
        if (!$this->primeAssurances->contains($primeAssurance)) {
            $this->primeAssurances->add($primeAssurance);
            $primeAssurance->setLot($this);
        }

        return $this;
    }

    public function removePrimeAssurance(PrimeAssurance $primeAssurance): static
    {
        if ($this->primeAssurances->removeElement($primeAssurance)) {
            // set the owning side to null (unless already changed)
            if ($primeAssurance->getLot() === $this) {
                $primeAssurance->setLot(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MandatGestionnaire>
     */
    public function getMandatGestionnaires(): Collection
    {
        return $this->mandatGestionnaires;
    }

    public function addMandatGestionnaire(MandatGestionnaire $mandatGestionnaire): static
    {
        if (!$this->mandatGestionnaires->contains($mandatGestionnaire)) {
            $this->mandatGestionnaires->add($mandatGestionnaire);
            $mandatGestionnaire->setLot($this);
        }

        return $this;
    }

    public function removeMandatGestionnaire(MandatGestionnaire $mandatGestionnaire): static
    {
        if ($this->mandatGestionnaires->removeElement($mandatGestionnaire)) {
            // set the owning side to null (unless already changed)
            if ($mandatGestionnaire->getLot() === $this) {
                $mandatGestionnaire->setLot(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Emprunt>
     */
    public function getEmprunts(): Collection
    {
        return $this->emprunts;
    }

    public function addEmprunt(Emprunt $emprunt): static
    {
        if (!$this->emprunts->contains($emprunt)) {
            $this->emprunts->add($emprunt);
            $emprunt->setLot($this);
        }

        return $this;
    }

    public function removeEmprunt(Emprunt $emprunt): static
    {
        if ($this->emprunts->removeElement($emprunt)) {
            // set the owning side to null (unless already changed)
            if ($emprunt->getLot() === $this) {
                $emprunt->setLot(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Travaux>
     */
    public function getTravauxes(): Collection
    {
        return $this->travauxes;
    }

    public function addTravaux(Travaux $travaux): static
    {
        if (!$this->travauxes->contains($travaux)) {
            $this->travauxes->add($travaux);
            $travaux->setLot($this);
        }

        return $this;
    }

    public function removeTravaux(Travaux $travaux): static
    {
        if ($this->travauxes->removeElement($travaux)) {
            // set the owning side to null (unless already changed)
            if ($travaux->getLot() === $this) {
                $travaux->setLot(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Location>
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(Location $location): static
    {
        if (!$this->locations->contains($location)) {
            $this->locations->add($location);
            $location->setLot($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): static
    {
        if ($this->locations->removeElement($location)) {
            // set the owning side to null (unless already changed)
            if ($location->getLot() === $this) {
                $location->setLot(null);
            }
        }

        return $this;
    }
}
