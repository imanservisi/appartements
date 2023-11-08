<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntrepriseRepository::class)]
class Entreprise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomEntreprise = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresseEntreprise = null;

    #[ORM\OneToMany(mappedBy: 'entreprise', targetEntity: Travaux::class)]
    private Collection $travauxes;

    public function __construct()
    {
        $this->travauxes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEntreprise(): ?string
    {
        return $this->nomEntreprise;
    }

    public function setNomEntreprise(string $nomEntreprise): static
    {
        $this->nomEntreprise = $nomEntreprise;

        return $this;
    }

    public function getAdresseEntreprise(): ?string
    {
        return $this->adresseEntreprise;
    }

    public function setAdresseEntreprise(?string $adresseEntreprise): static
    {
        $this->adresseEntreprise = $adresseEntreprise;

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
            $travaux->setEntreprise($this);
        }

        return $this;
    }

    public function removeTravaux(Travaux $travaux): static
    {
        if ($this->travauxes->removeElement($travaux)) {
            // set the owning side to null (unless already changed)
            if ($travaux->getEntreprise() === $this) {
                $travaux->setEntreprise(null);
            }
        }

        return $this;
    }
}
