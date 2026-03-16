<?php

namespace App\Controller;

use App\Entity\Location;
use App\Entity\Lot;
use App\Entity\Residence;
use App\Form\LocationType;
use App\Repository\CafRepository;
use App\Repository\LocationRepository;
use App\Repository\LoyerRepository;
use App\Service\DeclarationService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('residence/{residenceId}/lot/{lotId}/location')]
class LocationController extends AbstractController
{
    private string $domainName;

    public function __construct(string $domainName)
    {
        $this->domainName = $domainName;
    }

    #[Route('/', name: 'app_location_index', methods: ['GET'])]
    public function index(
        LocationRepository $locationRepository,
        DeclarationService $declarationService,
        #[MapEntity(id: 'residenceId')] Residence $residence,
        #[MapEntity(id: 'lotId')] Lot $lot
    ): Response {
        return $this->render('location/index.html.twig', [
            'locations' => $locationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_location_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        #[MapEntity(id: 'residenceId')] Residence $residence,
        #[MapEntity(id: 'lotId')] Lot $lot
    ): Response {
        $location = new Location();
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $location->setLot($lot);
            $entityManager->persist($location);
            $entityManager->flush();

            return $this->redirectToRoute('app_lot_edit', [
                'residenceId' => $residence->getId(),
                'id' => $lot->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('location/new.html.twig', [
            'location' => $location,
            'form' => $form,
            'residence' => $residence,
            'lot' => $lot
        ]);
    }

    #[Route('/{id}/edit', name: 'app_location_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Location $location,
        EntityManagerInterface $entityManager,
        #[MapEntity(id: 'residenceId')] Residence $residence,
        #[MapEntity(id: 'lotId')] Lot $lot,
        CafRepository $cafRepository,
        LoyerRepository $loyerRepository,
        DeclarationService $declarationService
    ): Response {
        $annees = $declarationService->createYearsArray();
        $anneeChoisie = $request->request->get('choix-annee', date('Y', strtotime('-1 year')));

        //Récupération des cafs liées à cette location
        $cafs = $cafRepository->findBy([
            'location' => $location,
            'annee' => $anneeChoisie
        ], ['mois' => 'ASC']);
        //Récupération des loyers liés à cette location
        $loyers = $loyerRepository->findBy([
            'location' => $location,
            'annee' => $anneeChoisie
        ], ['mois' => 'ASC']);
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_lot_edit', [
                'residenceId' => $residence->getId(),
                'id' => $lot->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('location/edit.html.twig', [
            'location' => $location,
            'form' => $form,
            'residence' => $residence,
            'lot' => $lot,
            'cafs' => $cafs,
            'loyers' => $loyers,
            'domain_name' => $this->domainName,
            'annees' => $annees,
            'annee_choisie' => $anneeChoisie
        ]);
    }

    #[Route('/{id}/delete', name: 'app_location_delete', methods: ['GET', 'POST'])]
    public function delete(
        Location $location,
        EntityManagerInterface $entityManager,
        #[MapEntity(id: 'residenceId')] Residence $residence,
        #[MapEntity(id: 'lotId')] Lot $lot
    ): Response {
        try {
            $entityManager->remove($location);
            $entityManager->flush();
            $this->addFlash('success', 'Location supprimée');
        } catch (Exception $e) {
            $this->addFlash('error', 'Suppression non possible.');
        }

        return $this->redirectToRoute('app_lot_edit', [
            'residenceId' => $residence->getId(),
            'id' => $lot->getId()
        ], Response::HTTP_SEE_OTHER);
    }
}
