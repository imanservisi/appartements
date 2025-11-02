<?php

namespace App\Controller;

use App\Repository\RecapitulatifRepository;
use App\Repository\ResidenceRepository;
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
        RecapitulatifRepository $recapitulatifRepository
    ): Response
    {
        $annees = $declarationService->createYearsArray();
        $anneeChoisie = $request->request->get('choix-annee', date('Y', strtotime('-1 year')));

        $residences = $residenceRepository->findAll();
        // $recapitulatifs = $recapitulatifRepository->findBy(['annee' => $anneeChoisie]);
        // TODO créer un modèle pour tout mettre en mémoire d'abord, afin de boucler sur le tableau des données
        $recapitulatifs = [];

        // exemples de lignes (à remplacer par logique réelle)
        $recapitulatifs[] = [
            'libelle' => '210 RECETTES',
            'valeurs' => [
                1 => 12345.67,
                2 => 23456.78,
                // ...
            ],
        ];

        $recapitulatifs[] = [
            'libelle' => '211 Loyers',
            'valeurs' => [
                1 => 9876.54,
                2 => 8765.43,
                // ...
            ],
        ];

        return $this->render('recapitulatif/index.html.twig', [
            'annees' => $annees,
            'annee_choisie' => $anneeChoisie,
            'residences' => $residences,
            'recapitulatifs' => $recapitulatifs
        ]);
    }
}
