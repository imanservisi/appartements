<?php

namespace App\Controller;

use App\Repository\CafRepository;
use App\Repository\FraisGestionRepository;
use App\Repository\LocationRepository;
use App\Repository\LotRepository;
use App\Repository\LoyerRepository;
use App\Repository\MandatGestionnaireRepository;
use App\Repository\ResidenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeclarationController extends AbstractController
{
    #[Route('/', name: 'app_declaration')]
    public function index(
        Request $request,
        ResidenceRepository $residenceRepository,
        LotRepository $lotRepository,
        LocationRepository $locationRepository,
        LoyerRepository $loyerRepository,
        CafRepository $cafRepository,
        MandatGestionnaireRepository $mandatGestionnaireRepository,
        FraisGestionRepository $fraisGestionRepository
    ): Response
    {
        //Récupération de la résidence
        $residence = $residenceRepository->findOneBy(['id' => 1]);
        //Récupération de tous les lots liés à la résidence
        $lots = $lotRepository->findBy(['residence' => $residence]);
        
        $sommeLoyer = 0;
        $sommeCaf = 0;
        $sommeMandatGestion = 0;
        foreach ($lots as $lot) {
            //Récupération des montants des loyers et de la CAF
            $locations = $locationRepository->findBy(['lot' => $lot]);
            foreach ($locations as $location) {
                $loyers = $loyerRepository->findBy(['location' => $location]);
                foreach ($loyers as $loyer) {
                    $sommeLoyer = $sommeLoyer + $loyer->getMontant();
                }
                $cafs = $cafRepository->findBy(['location' => $location]);
                foreach ($cafs as $caf) {
                    $sommeCaf = $sommeCaf + $caf->getMontantCaf();
                }
            }
            //Récupération des frais de gestion des mandats gestionnaires de tous les lots de la résidence
            $mandatsGestion = $mandatGestionnaireRepository->findBy(['lot' => $lot]);
            foreach ($mandatsGestion as $mandatGestion) {
                $fraisGestions = $fraisGestionRepository->findBy(['mandatGestionnaire' => $mandatGestion]);
                foreach ($fraisGestions as $fraisGestion) {
                    $sommeMandatGestion = $sommeMandatGestion + $fraisGestion->getMontant();
                }
            }
        }
        $montant211 = $sommeLoyer + $sommeCaf;

        return $this->render('declaration/index.html.twig', [
            'controller_name' => 'DeclarationController',
            'residence' => $residence,
            'montant211' => $montant211,
            'montant221' => $sommeMandatGestion
        ]);
    }
}
