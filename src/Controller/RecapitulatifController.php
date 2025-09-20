<?php

namespace App\Controller;

use App\Service\DeclarationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecapitulatifController extends AbstractController
{
    #[Route('/recapitulatif', name: 'app_recapitulatif')]
    public function index(Request $request, DeclarationService $declarationService): Response
    {
        $annees = $declarationService->createYearsArray();
        $anneeChoisie = $request->request->get('choix-annee', date('Y', strtotime('-1 year')));

        return $this->render('recapitulatif/index.html.twig', [
            'annees' => $annees,
            'annee_choisie' => $anneeChoisie,
        ]);
    }
}
