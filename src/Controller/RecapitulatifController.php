<?php

namespace App\Controller;

use App\Repository\RecapitulatifRepository;
use App\Repository\ResidenceRepository;
use App\Service\AssembleurRecap;
use App\Service\DeclarationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecapitulatifController extends AbstractController
{
    #[Route('/recapitulatif', name: 'app_recapitulatif')]
    public function index(
        Request $request,
        DeclarationService $declarationService,
        ResidenceRepository $residenceRepository,
        RecapitulatifRepository $recapitulatifRepository,
        AssembleurRecap $assembleurRecap
    ): Response
    {
        $annees = $declarationService->createYearsArray();
        $anneeChoisie = $request->request->get('choix-annee', date('Y', strtotime('-1 year')));

        $residences = $residenceRepository->findAll();
        $recap = $recapitulatifRepository->findBy(['annee' => $anneeChoisie]);
        // dd($recap);
        $recapitulatifs = $assembleurRecap->assembleRecapitulatif($recap);

        // $recapitulatifs = [];

        // // exemples de lignes (à remplacer par logique réelle)
        // $recapitulatifs[] = [
        //     'libelle' => '210 RECETTES',
        //     'valeurs' => [
        //         'Galion' => 12345.67,
        //         'Panorama' => 23456.78,
        //         'Cravache' => 123,
        //         'Schiaffini' => null,
        //         'Vallon des Auffes' => null,
        //         'Domaine des Lauriers' => 456
        //     ],
        // ];

        // $recapitulatifs[] = [
        //     'libelle' => '211 Loyers',
        //     'valeurs' => [
        //         'Galion' => 9876.54,
        //         'Panorama' => 8765.43,
        //         'Cravache' => 456,
        //         'Schiaffini' => null,
        //         'Vallon des Auffes' => null,
        //         'Domaine des Lauriers' => 456
        //     ],
        // ];

        return $this->render('recapitulatif/index.html.twig', [
            'annees' => $annees,
            'annee_choisie' => $anneeChoisie,
            'residences' => $residences,
            'recapitulatifs' => $recapitulatifs
        ]);
    }
}
