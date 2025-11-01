<?php

namespace App\Service;

use App\Repository\CafRepository;
use App\Repository\FraisGestionRepository;
use App\Repository\LoyerRepository;

class Calculator
{
    public function __construct(
        private LoyerRepository $loyerRepository,
        private CafRepository $cafRepository,
        private FraisGestionRepository $fraisGestionRepository
    )
    {
        
    }

    public function calculsPourLocation(
        string $anneeChoisie,
        array $locations
    )
    {
        $sommeLoyer = 0;
        $sommeCaf = 0;
        foreach ($locations as $location) {
                $loyers = $this->loyerRepository->findBy([
                    'location' => $location,
                    'annee' => $anneeChoisie
                ]);
                foreach ($loyers as $loyer) {
                    $sommeLoyer += $loyer->getMontant();
                }
                $cafs = $this->cafRepository->findBy([
                    'location' => $location,
                    'annee' => $anneeChoisie
                ]);
                foreach ($cafs as $caf) {
                    $sommeCaf += $caf->getMontantCaf();
                }
        }

        return [
            'sommeLoyer' => $sommeLoyer,
            'sommeCaf' => $sommeCaf
        ];
    }

    public function calculMandatGestion(
        string $anneeChoisie,
        array $mandatsGestion
    )
    {
        $sommeMandatGestion = 0;
        foreach ($mandatsGestion as $mandatGestion) {
                $fraisGestions = $this->fraisGestionRepository->findBy([
                    'mandatGestionnaire' => $mandatGestion,
                    'annee' => $anneeChoisie
                ]);
                foreach ($fraisGestions as $fraisGestion) {
                    $sommeMandatGestion += $fraisGestion->getMontant();
                }
        }

        return [
            'sommeMandatGestion' => $sommeMandatGestion
        ];
    }
}