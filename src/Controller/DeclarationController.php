<?php

namespace App\Controller;

use App\Entity\Recapitulatif;
use App\Entity\Residence;
use App\Repository\CafRepository;
use App\Repository\ChargeRepository;
use App\Repository\EmpruntRepository;
use App\Repository\FraisGestionRepository;
use App\Repository\InteretRepository;
use App\Repository\LocationRepository;
use App\Repository\LotRepository;
use App\Repository\LoyerRepository;
use App\Repository\MandatGestionnaireRepository;
use App\Repository\PrimeAssuranceRepository;
use App\Repository\RegularisationPonctuelleRepository;
use App\Repository\ResidenceRepository;
use App\Repository\TaxeFonciereRepository;
use App\Repository\TravauxRepository;
use App\Service\DeclarationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        FraisGestionRepository $fraisGestionRepository,
        PrimeAssuranceRepository $primeAssuranceRepository,
        TravauxRepository $travauxRepository,
        TaxeFonciereRepository $taxeFonciereRepository,
        ChargeRepository $chargeRepository,
        EmpruntRepository $empruntRepository,
        InteretRepository $interetRepository,
        RegularisationPonctuelleRepository $regularisationPonctuelleRepository,
        DeclarationService $declarationService
    ): Response {
        $annees = $declarationService->createYearsArray();
        $idResidence = $request->request->get('choix-residence', "1");
        $anneeChoisie = $request->request->get('choix-annee', date('Y', strtotime('-1 year')));
        //Récupération de la résidence en fonction de l'idResidence demandé
        $residence = $residenceRepository->findOneBy(['id' => $idResidence]);
        $nbLots = count($residence->getLot());
        //Récupération de tous les lots liés à la résidence
        $lots = $lotRepository->findBy(['residence' => $residence]);
        
        $sommeLoyer = 0;
        $sommeCaf = 0;
        $sommeMandatGestion = 0;
        $sommePrimesAssurance = 0;
        $sommeTravaux = 0;
        $sommeCharges = 0;
        $sommeEmprunt = 0;
        $lotsId = [];
        foreach ($lots as $lot) {
            //Récupération de la liste des ids des lots
            $lotsId[] = $lot->getId();
            //Récupération des montants des loyers et de la CAF
            $locations = $locationRepository->findBy([
                'lot' => $lot
            ]);
            foreach ($locations as $location) {
                $loyers = $loyerRepository->findBy([
                    'location' => $location,
                    'annee' => $anneeChoisie
                ]);
                foreach ($loyers as $loyer) {
                    $sommeLoyer = $sommeLoyer + $loyer->getMontant();
                }
                $cafs = $cafRepository->findBy([
                    'location' => $location,
                    'annee' => $anneeChoisie
                ]);
                foreach ($cafs as $caf) {
                    $sommeCaf = $sommeCaf + $caf->getMontantCaf();
                }
            }
            //Récupération des frais de gestion des mandats gestionnaires de tous les lots de la résidence
            $mandatsGestion = $mandatGestionnaireRepository->findBy(['lot' => $lot]);
            foreach ($mandatsGestion as $mandatGestion) {
                $fraisGestions = $fraisGestionRepository->findBy([
                    'mandatGestionnaire' => $mandatGestion,
                    'annee' => $anneeChoisie
                ]);
                foreach ($fraisGestions as $fraisGestion) {
                    $sommeMandatGestion = $sommeMandatGestion + $fraisGestion->getMontant();
                }
            }
            //Récupération des primes d'assurance
            $primesAssurance = $primeAssuranceRepository->findBy([
                'lot' => $lot,
                'annee' => $anneeChoisie
            ]);
            foreach ($primesAssurance as $prime) {
                $sommePrimesAssurance = $sommePrimesAssurance + $prime->getMontant();
            }
            //Récupération des travaux
            $montantsTravaux = $travauxRepository->findBy([
                'lot' => $lot,
                'annee' => $anneeChoisie
            ]);
            foreach ($montantsTravaux as $travaux) {
                $sommeTravaux = $sommeTravaux + $travaux->getMontantTravaux();
            }
            //Récupération des charges
            $montantsCharges = $chargeRepository->findBy([
                'lot' => $lot,
                'annee' => $anneeChoisie
            ]);
            foreach ($montantsCharges as $charge) {
                $sommeCharges = $sommeCharges + $charge->getMontant();
            }
            //Récupération des emprunts
            $emprunts = $empruntRepository->findBy([
                'lot' => $lot,
            ]);
            foreach ($emprunts as $emprunt) {
                $montantsInterets = $interetRepository->findBy([
                    'emprunt' => $emprunt,
                    'annee' => $anneeChoisie
                ]);
                foreach ($montantsInterets as $interet) {
                    $sommeEmprunt = $sommeEmprunt + $interet->getMontantInteret();
                }
            }
        }
        $montant211 = $sommeLoyer + $sommeCaf;
        $montant222 = 20 * $nbLots;
        //Récupération de la taxe foncière
        $taxeFonciere = $taxeFonciereRepository->findOneBy([
            'residence' => $residence,
            'annee' => $anneeChoisie
        ]);
        $montantTaxeFonciere = !empty($taxeFonciere) ? $taxeFonciere->getMontant() : 0;

        // Récupération des régul ponctuelles (229bis, 230 et 230bis)
        $montant230 = 0;
        $montant229bis = 0;
        $montant230bis = 0;
        $regulsPonctuelles = $regularisationPonctuelleRepository->findOneBy([
            'residence' => $residence,
            'annee' => $anneeChoisie
        ]);
        if (!is_null($regulsPonctuelles)) {
            $montant229bis = !is_null($regulsPonctuelles->getMontant229bis()) ? $regulsPonctuelles->getMontant229bis() : 0;
            $montant230 = !is_null($regulsPonctuelles->getMontant230()) ? $regulsPonctuelles->getMontant230() : 0;
            $montant230bis = !is_null($regulsPonctuelles->getMontant230bis()) ? $regulsPonctuelles->getMontant230bis() : 0;
        }

        // Calcul total frais et charges (240)
        // 240 = 221 + 222 + 223 + 224 + 227 + 229 + 229bis - 230 - 230bis
        $totalFraisCharges = $sommeMandatGestion + $montant222 + $sommePrimesAssurance +
        $sommeTravaux + $montantTaxeFonciere + $sommeCharges + $montant229bis - $montant230 - $montant230bis;

        //Calcul 215-240-250
        $montant261 = $montant211 - $totalFraisCharges - $sommeEmprunt;
        $AllTravaux = $travauxRepository->findByLotsIdAndYear($lotsId, $anneeChoisie);

        return $this->render('declaration/index.html.twig', [
            'annees' => $annees,
            'residences' => $residenceRepository->findAll(),
            'residence' => $residence,
            'montant211' => $montant211,
            'montant221' => $sommeMandatGestion,
            'montant222' => $montant222,
            'montant223' => $sommePrimesAssurance,
            'montant224' => $sommeTravaux,
            'montant227' => $montantTaxeFonciere,
            'montant229' => $sommeCharges,
            'montant229bis' => $montant229bis,
            'montant230' => $montant230,
            'montant230bis' => $montant230bis,
            'montant240' => $totalFraisCharges,
            'montant250' => $sommeEmprunt,
            'montant261' => $montant261,
            'allTravaux' => $AllTravaux,
            'annee_choisie' => $anneeChoisie,
            'residence_choisie' => $idResidence,
            'regulsPonctuelles' => $regulsPonctuelles
        ]);
    }

    #[Route('/genererRecapitulatif/{residence}', name: 'app_generer_recapitulatif')]
    public function genererRecapitulatif(
        Request $request,
        Residence $residence,
        EntityManagerInterface $em
    ): JsonResponse
    {
        // TODO : mettre en place la mise à jour
        $loyer = $request->get('loyer');
        $recap = new Recapitulatif();
        $recap->setResidence($residence);
        $recap->setAnnee('2026');
        $recap->setLoyer($loyer);
        $recap->setTotalRecette(0);
        $recap->setFraisAdm(0);
        $recap->setAutresFrais(0);             
        $recap->setPrimesAssurances(0);
        $recap->setTravaux(0);
        $recap->setTaxeFonciere(0);
        $recap->setProvisionPourCharge(0);
        $recap->setInteretEmprunt(0);
        $recap->setMontant261(0);
        $em->persist($recap);
        $em->flush();

        return new JsonResponse('ok', 200);
    }
}
