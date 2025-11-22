<?php

namespace App\Service;

class AssembleurRecap {
    public function assembleRecapitulatif(array $bddRecap)
    {
        // Récupération de la liste des résidences
        $residences = [];
        foreach ($bddRecap as $recap) {
            $residence = $recap->getResidence();
            $residences[$residence->getNomResidence()] = $residence->getNomResidence();
            $nomsResidence = array_values($residences);
            sort($nomsResidence);
        }
        // mapping libellé => getter sur l'entité Recapitulatif
        $lignes = [
            'Loyers' => 'getLoyer',
            'Total recettes' => 'getTotalRecette',
            'Frais administratifs' => 'getFraisAdm',
            'Autres frais' => 'getAutresFrais',
            'Primes assurances' => 'getPrimesAssurances',
            'Travaux' => 'getTravaux',
            'Taxe foncière' => 'getTaxeFonciere',
            'Montant 229bis' => 'getMontant229bis',
            'Montant 230' => 'getMontant230',
            'Montant 230bis' => 'getMontant230bis',
            'Total charges' => 'getProvisionPourCharge',
            'Intérêts emprunt' => 'getInteretEmprunt',
            'Montant 261' => 'getMontant261',
        ];
        // initialiser les lignes avec des valeurs null pour chaque résidence
        $recapitulatifs = [];
        foreach ($lignes as $libelle => $getter) {
            $recapitulatifs[$libelle] = [
                'libelle' => $libelle,
                'valeurs' => array_fill_keys($nomsResidence, null),
            ];
        }

        // remplir avec les valeurs extraites des entités
        foreach ($bddRecap as $r) {
            $nom = $r->getResidence()->getNomResidence();

            foreach ($lignes as $libelle => $getter) {
                $val = $r->{$getter}();
                $recapitulatifs[$libelle]['valeurs'][$nom] = $val !== null ? (float) $val : null;
            }
        }

        return array_values($recapitulatifs);
    }
}