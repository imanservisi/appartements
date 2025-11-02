<?php

namespace App\Service;

use App\Repository\LocationRepository;
use App\Repository\MandatGestionnaireRepository;
use App\Repository\PrimeAssuranceRepository;
use App\Repository\TravauxRepository;
use App\Repository\ChargeRepository;
use App\Repository\EmpruntRepository;
use App\Repository\InteretRepository;

class SommeParLot
{
    public function __construct(
        private LocationRepository $locationRepository,
        private MandatGestionnaireRepository $mandatGestionnaireRepository,
        private PrimeAssuranceRepository $primeAssuranceRepository,
        private TravauxRepository $travauxRepository,
        private ChargeRepository $chargeRepository,
        private EmpruntRepository $empruntRepository,
        private InteretRepository $interetRepository,
    )
    {
        
    }

    public function calculerSommesParLots(
        array $lots,
        string $anneeChoisie,
        Calculator $calculator
    ): array {
        $sommeLoyer = 0;
        $sommeCaf = 0;
        $sommeMandatGestion = 0;
        $sommePrimesAssurance = 0;
        $sommeTravaux = 0;
        $sommeCharges = 0;
        $sommeEmprunt = 0;
        $lotsId = [];

        foreach ($lots as $lot) {
            $lotsId[] = $lot->getId();
            
            // Calcul locations et CAF
            $locations = $this->locationRepository->findBy(['lot' => $lot]);
            $sommesLocations = $calculator->calculsPourLocation($anneeChoisie, $locations);
            $sommeCaf += $sommesLocations['sommeCaf'];
            $sommeLoyer += $sommesLocations['sommeLoyer'];
            
            // Calcul mandats de gestion
            $mandatsGestion = $this->mandatGestionnaireRepository->findBy(['lot' => $lot]);
            $calculMandatsGestion = $calculator->calculMandatGestion($anneeChoisie, $mandatsGestion);
            $sommeMandatGestion += $calculMandatsGestion['sommeMandatGestion'];
            
            // Calcul primes d'assurance
            $primesAssurance = $this->primeAssuranceRepository->findBy([
                'lot' => $lot,
                'annee' => $anneeChoisie
            ]);
            foreach ($primesAssurance as $prime) {
                $sommePrimesAssurance += $prime->getMontant();
            }
            
            // Calcul travaux
            $montantsTravaux = $this->travauxRepository->findBy([
                'lot' => $lot,
                'annee' => $anneeChoisie
            ]);
            foreach ($montantsTravaux as $travaux) {
                $sommeTravaux += $travaux->getMontantTravaux();
            }
            
            // Calcul charges
            $montantsCharges = $this->chargeRepository->findBy([
                'lot' => $lot,
                'annee' => $anneeChoisie
            ]);
            foreach ($montantsCharges as $charge) {
                $sommeCharges += $charge->getMontant();
            }
            
            // Calcul emprunts
            $emprunts = $this->empruntRepository->findBy(['lot' => $lot]);
            foreach ($emprunts as $emprunt) {
                $montantsInterets = $this->interetRepository->findBy([
                    'emprunt' => $emprunt,
                    'annee' => $anneeChoisie
                ]);
                foreach ($montantsInterets as $interet) {
                    $sommeEmprunt = $sommeEmprunt + $interet->getMontantInteret();
                }
            }
        }

        return [
            'sommeLoyer' => $sommeLoyer,
            'sommeCaf' => $sommeCaf,
            'sommeMandatGestion' => $sommeMandatGestion,
            'sommePrimesAssurance' => $sommePrimesAssurance,
            'sommeTravaux' => $sommeTravaux,
            'sommeCharges' => $sommeCharges,
            'sommeEmprunt' => $sommeEmprunt,
            'lotsId' => $lotsId
        ];
    }
}