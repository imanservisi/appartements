<?php

namespace App\Service;

use App\Entity\Residence;
use App\Repository\LotRepository;
use App\Repository\RegularisationPonctuelleRepository;
use App\Repository\TaxeFonciereRepository;
use App\Repository\TravauxRepository;

class DonneesResidenceService
{
    public function __construct(
        private readonly LotRepository $lotRepository,
        private readonly TaxeFonciereRepository $taxeFonciereRepository,
        private readonly RegularisationPonctuelleRepository $regularisationPonctuelleRepository,
        private readonly TravauxRepository $travauxRepository
    ) {}

    public function recupererDonneesResidence(
        ?Residence $residence,
        string $anneeChoisie,
        $lotsId
    ): array
    {
        //Récupération de tous les lots liés à la résidence
        $lots = $this->lotRepository->findBy(['residence' => $residence]);
        //Récupération de la taxe foncière
        $taxeFonciere = $this->taxeFonciereRepository->findOneBy([
            'residence' => $residence,
            'annee' => $anneeChoisie
        ]);
        $regulsPonctuelles = $this->regularisationPonctuelleRepository->findOneBy([
            'residence' => $residence,
            'annee' => $anneeChoisie
        ]);
        $allTravaux = $this->travauxRepository->findByLotsIdAndYear(
            $lotsId,
            $anneeChoisie
        );

        return [$lots, $taxeFonciere, $regulsPonctuelles, $allTravaux];
    }
}
