<?php

namespace App\Model;

class Montants
{
    private float $montant211;
    private float $montant221;
    private int $montant222;
    private float $montant223;
    private float $montant224;
    private int $montant227;
    private float $montant229;
    private float $montant229bis;
    private float $montant230;
    private float $montant230bis;
    private float $montant240;
    private float $montant250;
    private float $montant261;

    public function __construct(float $montant211 = 0.0, float $montant221 = 0.0)
    {
        $this->montant211 = $montant211;
        $this->montant221 = $montant221;
    }

    public function getMontant211(): float
    {
        return $this->montant211;
    }

    public function setMontant211(float $montant211): self
    {
        $this->montant211 = $montant211;
        return $this;
    }

    public function getMontant221(): float
    {
        return $this->montant221;
    }

    public function setMontant221(float $montant221): self
    {
        $this->montant221 = $montant221;
        return $this;
    }

    public function getMontant222(): int
    {
        return $this->montant222;
    }

    public function setMontant222(int $montant222): self
    {
        $this->montant222 = $montant222;
        return $this;
    }

    public function getMontant223(): float
    {
        return $this->montant223;
    }

    public function setMontant223(float $montant223): self
    {
        $this->montant223 = $montant223;
        return $this;
    }

    public function getMontant224(): float
    {
        return $this->montant224;
    }

    public function setMontant224(float $montant224): self
    {
        $this->montant224 = $montant224;
        return $this;
    }

    public function getMontant227(): int
    {
        return $this->montant227;
    }

    public function setMontant227(int $montant227): self
    {
        $this->montant227 = $montant227;
        return $this;
    }

    public function getMontant229(): float
    {
        return $this->montant229;
    }

    public function setMontant229(float $montant229): self
    {
        $this->montant229 = $montant229;
        return $this;
    }

    public function getMontant229bis(): float
    {
        return $this->montant229bis;
    }

    public function setMontant229bis(float $montant229bis): self
    {
        $this->montant229bis = $montant229bis;
        return $this;
    }

    public function getMontant230(): float
    {
        return $this->montant230;
    }

    public function setMontant230(float $montant230): self
    {
        $this->montant230 = $montant230;
        return $this;
    }

    public function getMontant230bis(): float
    {
        return $this->montant230bis;
    }

    public function setMontant230bis(float $montant230bis): self
    {
        $this->montant230bis = $montant230bis;
        return $this;
    }

    public function getMontant240(): float
    {
        return $this->montant240;
    }

    public function setMontant240(float $montant240): self
    {
        $this->montant240 = $montant240;
        return $this;
    }

    public function getMontant250(): float
    {
        return $this->montant250;
    }

    public function setMontant250(float $montant250): self
    {
        $this->montant250 = $montant250;
        return $this;
    }

    public function getMontant261(): float
    {
        return $this->montant261;
    }

    public function setMontant261(float $montant261): self
    {
        $this->montant261 = $montant261;
        return $this;
    }
}
