<?php

namespace App\Controller;

use App\Entity\Recapitulatif;
use App\Entity\Residence;
use App\Repository\ChargeRepository;
use App\Repository\EmpruntRepository;
use App\Repository\InteretRepository;
use App\Repository\LocationRepository;
use App\Repository\LotRepository;
use App\Repository\MandatGestionnaireRepository;
use App\Repository\PrimeAssuranceRepository;
use App\Repository\RecapitulatifRepository;
use App\Repository\RegularisationPonctuelleRepository;
use App\Repository\ResidenceRepository;
use App\Repository\TaxeFonciereRepository;
use App\Repository\TravauxRepository;
use App\Service\AssembleurDonnees;
use App\Service\Calculator;
use App\Service\DeclarationService;
use App\Service\SommeParLot;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeclarationController extends AbstractController
{
    public function __construct(
    )
    {
        
    }
    #[Route('/', name: 'app_declaration')]
    public function index(
        Request $request,
        ResidenceRepository $residenceRepository,
        LotRepository $lotRepository,
        TravauxRepository $travauxRepository,
        TaxeFonciereRepository $taxeFonciereRepository,
        RegularisationPonctuelleRepository $regularisationPonctuelleRepository,
        DeclarationService $declarationService,
        Calculator $calculator,
        AssembleurDonnees $assembleur,
        SommeParLot $sommeParLot
    ): Response {
        $annees = $declarationService->createYearsArray();
        $idResidence = $request->request->get('choix-residence', "1");
        $anneeChoisie = $request->request->get('choix-annee', date('Y', strtotime('-1 year')));
        //Récupération de la résidence en fonction de l'idResidence demandé
        $residence = $residenceRepository->findOneBy(['id' => $idResidence]);
        //Récupération de tous les lots liés à la résidence
        $lots = $lotRepository->findBy(['residence' => $residence]);

        $sommesLots = $sommeParLot->calculerSommesParLots(
            $lots,
            $anneeChoisie,
            $calculator
        );
        
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

        $allTravaux = $travauxRepository->findByLotsIdAndYear($sommesLots['lotsId'], $anneeChoisie);

        $montants = $assembleur->assembleMontants(
            $sommesLots['sommeLoyer'],
            $sommesLots['sommeCaf'],
            $sommesLots['sommeMandatGestion'],
            count($lots),
            $sommesLots['sommePrimesAssurance'],
            $sommesLots['sommeTravaux'],
            $montantTaxeFonciere,
            $sommesLots['sommeCharges'],
            $montant229bis,
            $montant230,
            $montant230bis,
            $sommesLots['sommeEmprunt']
        );

        return $this->render('declaration/index.html.twig', [
            'annees' => $annees,
            'residences' => $residenceRepository->findAll(),
            'residence' => $residence,
            'allTravaux' => $allTravaux,
            'annee_choisie' => $anneeChoisie,
            'residence_choisie' => $idResidence,
            'regulsPonctuelles' => $regulsPonctuelles,
            'montants' => $montants
        ]);
    }

    #[Route('/genererRecapitulatif/{residence}', name: 'app_generer_recapitulatif')]
    public function genererRecapitulatif(
        Request $request,
        Residence $residence,
        EntityManagerInterface $em,
        RecapitulatifRepository $recapitulatifRepository
    ): JsonResponse
    {
        $annee = $request->get('annee');
        // Vérification si un récap existe déjà pour l'année et la résidence. Si n'existe pas, création
        $recap = $recapitulatifRepository->findOneBy([
            'residence' => $residence->getId(),
            'annee' => $annee
        ]);
        if (is_null($recap)) {
            $recap = new Recapitulatif();
            $recap->setAnnee($annee);
            $recap->setResidence($residence);
        }
        // Récupération de toutes les données
        $montants = $request->get('montants');
        if (is_string($montants)) {
            $montants = json_decode($montants, true);
        }
        
        // Mise à jour de l'entité
        $recap->setLoyer($montants['211']);
        $recap->setTotalRecette($montants['211']);
        $recap->setFraisAdm($montants['221']);
        $recap->setAutresFrais($montants['222']);
        $recap->setPrimesAssurances($montants['223']);
        $recap->setTravaux($montants['224']);
        $recap->setTaxeFonciere($montants['227']);
        $recap->setProvisionPourCharge($montants['229']);
        $recap->setMontant229bis($montants['229bis']);
        $recap->setMontant230($montants['230']);
        $recap->setMontant230bis($montants['230bis']);
        $recap->setProvisionPourCharge($montants['240']);
        $recap->setInteretEmprunt($montants['250']);
        $recap->setMontant261($montants['261']);
        dd([$montants, $recap]);
        
        // $em->persist($recap);
        // $em->flush();

        return new JsonResponse('ok', 200);
    }
}
