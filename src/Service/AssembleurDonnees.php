<?php

namespace App\Service;

use App\Model\Montants;

class AssembleurDonnees
{
    public function assembleMontants(
        int $sommeLoyer,
        int $sommeCaf,
        int $sommeMandatGestion,
        int $nbLots,
        float $sommePrimesAssurance,
        float $sommeTravaux,
        int $montantTaxeFonciere,
        float $sommeCharges,
        int $montant229bis,
        int $montant230,
        int $montant230bis,
        float $sommeEmprunt
    ): array
    {
        // Calcul total frais et charges (240)
        // 240 = 221 + 222 + 223 + 224 + 227 + 229 + 229bis - 230 - 230bis
        $totalFraisCharges = $sommeMandatGestion + (20 * $nbLots) + $sommePrimesAssurance +
        $sommeTravaux + $montantTaxeFonciere + $sommeCharges + $montant229bis - $montant230 - $montant230bis;

        //Calcul 261 = 215-240-250
        $montant261 = $sommeLoyer + $sommeCaf - $totalFraisCharges - $sommeEmprunt;

        return [
            '211' => $sommeLoyer + $sommeCaf,
            '221' => $sommeMandatGestion,
            '222' => 20 * $nbLots,
            '223' => $sommePrimesAssurance,
            '224' => $sommeTravaux,
            '227' => $montantTaxeFonciere,
            '229' => $sommeCharges,
            '229bis' => $montant229bis,
            '230' => $montant230,
            '230bis' => $montant230bis,
            '240' => $totalFraisCharges,
            '250' => $sommeEmprunt,
            '261' => $montant261,
        ];
    }
}