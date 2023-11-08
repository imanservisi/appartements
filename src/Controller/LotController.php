<?php

namespace App\Controller;

use App\Entity\FraisGestion;
use App\Entity\Lot;
use App\Entity\Residence;
use App\Form\LotType;
use App\Repository\ChargeRepository;
use App\Repository\EmpruntRepository;
use App\Repository\FraisGestionRepository;
use App\Repository\LocationRepository;
use App\Repository\LotRepository;
use App\Repository\MandatGestionnaireRepository;
use App\Repository\PrimeAssuranceRepository;
use App\Repository\TravauxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('residence/{residenceId}/lot')]
class LotController extends AbstractController
{
    #[Route('/', name: 'app_lot_index', methods: ['GET'])]
    public function index(LotRepository $lotRepository): Response
    {
        return $this->render('lot/index.html.twig', [
            'lots' => $lotRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_lot_new', methods: ['GET', 'POST'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Residence $residence): Response
    {
        $lot = new Lot();
        $form = $this->createForm(LotType::class, $lot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lot->setResidence($residence);
            $entityManager->persist($lot);
            $entityManager->flush();

            return $this->redirectToRoute('app_residence_show', [
                'id' => $residence->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('lot/new.html.twig', [
            'lot' => $lot,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_lot_show', methods: ['GET'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    public function show(Lot $lot): Response
    {
        return $this->render('lot/show.html.twig', [
            'lot' => $lot,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_lot_edit', methods: ['GET', 'POST'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    public function edit(
        Request $request,
        Residence $residence,
        Lot $lot,
        EntityManagerInterface $entityManager,
        ChargeRepository $chargeRepository,
        PrimeAssuranceRepository $primeAssuranceRepository,
        MandatGestionnaireRepository $mandatGestionnaireRepository,
        EmpruntRepository $empruntRepository,
        TravauxRepository $travauxRepository,
        LocationRepository $locationRepository
        ): Response {
        //Récupération des charges liées au lot
        $charges = $chargeRepository->findBy(['lot' => $lot]);
        //Récupération des primes d'assurance liés au lot
        $primesAssurance = $primeAssuranceRepository->findBy(['lot' => $lot]);
        //Récupération des mandats de gestion liés au lot
        $mandatGestionnaires = $mandatGestionnaireRepository->findBy(['lot' => $lot]);
        //Récupération des emprunts liés au lot
        $emprunts = $empruntRepository->findBy(['lot' => $lot]);
        //Récupération des emprunts liés au lot
        $travauxes = $travauxRepository->findBy(['lot' => $lot]);
        //Récupération des locations liés au lot
        $locations = $locationRepository->findBy(['lot' => $lot]);

        $form = $this->createForm(LotType::class, $lot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_residence_show', [
                'id' => $residence->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('lot/edit.html.twig', [
            'residence' => $residence,
            'lot' => $lot,
            'form' => $form,
            'charges' => $charges,
            'prime_assurances' => $primesAssurance,
            'mandat_gestionnaires' => $mandatGestionnaires,
            'emprunts' => $emprunts,
            'travauxes' => $travauxes,
            'locations' => $locations
        ]);
    }

    #[Route('/{id}', name: 'app_lot_delete', methods: ['POST'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    public function delete(Request $request, Residence $residence, Lot $lot, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lot->getId(), $request->request->get('_token'))) {
            $entityManager->remove($lot);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_residence_show', [
            'id' => $residence->getId()
        ], Response::HTTP_SEE_OTHER);
    }
}
