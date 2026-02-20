<?php

namespace App\Service;

use App\DTO\DonneesComptables;

class AssembleurDonnees
{
    public function assembleMontants(
        DonneesComptables $donnees
    ): array
    {
        // Calcul total frais et charges (240)
        // 240 = 221 + 222 + 223 + 224 + 227 + 229 + 229bis - 230 - 230bis
        $totalFraisCharges = $donnees->sommeMandatGestion + (20 * $donnees->nbLots) +
            $donnees->sommePrimesAssurance + $donnees->sommeTravaux +
            $donnees->montantTaxeFonciere + $donnees->sommeCharges +
            $donnees->montant229bis - $donnees->montant230 -
            $donnees->montant230bis;

        //Calcul 261 = 215-240-250
        $montant261 = $donnees->sommeLoyer + $donnees->sommeCaf -
            $totalFraisCharges - $donnees->sommeEmprunt;

        return [
            '211' => $donnees->sommeLoyer + $donnees->sommeCaf,
            '221' => $donnees->sommeMandatGestion,
            '222' => 20 * $donnees->nbLots,
            '223' => $donnees->sommePrimesAssurance,
            '224' => $donnees->sommeTravaux,
            '227' => $donnees->montantTaxeFonciere,
            '229' => $donnees->sommeCharges,
            '229bis' => $donnees->montant229bis,
            '230' => $donnees->montant230,
            '230bis' => $donnees->montant230bis,
            '240' => $totalFraisCharges,
            '250' => $donnees->sommeEmprunt,
            '261' => $montant261,
        ];
    }
}
