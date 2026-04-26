<?php

namespace App\Controller;

use App\Repository\RecapitulatifRepository;
use App\Repository\ResidenceRepository;
use App\Repository\TravauxRepository;
use App\Service\AssembleurRecap;
use App\Service\DeclarationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecapitulatifController extends AbstractController
{
    #[Route('/recapitulatifResidences', name: 'app_recapitulatif')]
    public function recapitulatifResidences(
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
        $recapitulatifs = empty($recap) ? [] : $assembleurRecap->assembleRecapitulatif($recap);

        return $this->render('recapitulatif/residences.html.twig', [
            'annees' => $annees,
            'annee_choisie' => $anneeChoisie,
            'residences' => $residences,
            'recapitulatifs' => $recapitulatifs
        ]);
    }

    #[Route('/recapitulatifTravaux', name: 'app_recapitulatif_travaux')]
    public function recapitulatifTravaux(
        Request $request,
        DeclarationService $declarationService,
        TravauxRepository $travauxRepository
        )
    {
       $annees = $declarationService->createYearsArray();
       $anneeChoisie = $request->request->get('choix-annee', date('Y', strtotime('-1 year')));
       $travaux = $travauxRepository->findByYearOrderByResidence($anneeChoisie);
       
       return $this->render('recapitulatif/travaux.html.twig', [
            'annees' => $annees,
            'annee_choisie' => $anneeChoisie,
            'travaux' => $travaux
        ]);
    }
}
