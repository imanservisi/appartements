<?php

namespace App\DTO;

class DonneesComptables
{
    public function __construct(
        public readonly int $sommeLoyer,
        public readonly int $sommeCaf,
        public readonly int $sommeMandatGestion,
        public readonly int $nbLots,
        public readonly float $sommePrimesAssurance,
        public readonly float $sommeTravaux,
        public readonly int $montantTaxeFonciere,
        public readonly float $sommeCharges,
        public readonly int $montant229bis,
        public readonly int $montant230,
        public readonly int $montant230bis,
        public readonly float $sommeEmprunt
    )
    {
    }
}
