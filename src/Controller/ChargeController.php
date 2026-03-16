<?php

namespace App\Controller;

use App\Entity\Charge;
use App\Entity\Lot;
use App\Entity\Residence;
use App\Form\ChargeType;
use App\Repository\ChargeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('residence/{residenceId}/lot/{lotId}/charge')]
class ChargeController extends AbstractController
{
    #[Route('/', name: 'app_charge_index', methods: ['GET'])]
    public function index(
        ChargeRepository $chargeRepository,
        #[MapEntity(id: 'residenceId')] Residence $residence,
        #[MapEntity(id: 'lotId')] Lot $lot
    ): Response {
        return $this->render('charge/index.html.twig', [
            'charges' => $chargeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_charge_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        #[MapEntity(id: 'residenceId')] Residence $residence,
        #[MapEntity(id: 'lotId')] Lot $lot
    ): Response {
        $charge = new Charge();
        $form = $this->createForm(ChargeType::class, $charge, ['lot_id' => $lot]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $charge->setLot($lot);
            $entityManager->persist($charge);
            $entityManager->flush();

            return $this->redirectToRoute('app_lot_edit', [
                'residenceId' => $residence->getId(),
                'id' => $lot->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('charge/new.html.twig', [
            'charge' => $charge,
            'form' => $form,
            'residence' => $residence,
            'lot' => $lot
        ]);
    }

    #[Route('/{id}/edit', name: 'app_charge_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Charge $charge,
        EntityManagerInterface $entityManager,
        #[MapEntity(id: 'residenceId')] Residence $residence,
        #[MapEntity(id: 'lotId')] Lot $lot
    ): Response {
        $form = $this->createForm(ChargeType::class, $charge, ['lot_id' => $lot]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_lot_edit', [
                'residenceId' => $residence->getId(),
                'id' => $lot->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('charge/edit.html.twig', [
            'charge' => $charge,
            'form' => $form,
            'residence' => $residence,
            'lot' => $lot
        ]);
    }

    #[Route('/{id}/delete', name: 'app_charge_delete', methods: ['GET', 'POST'])]
    public function delete(
        Charge $charge,
        EntityManagerInterface $entityManager,
        #[MapEntity(id: 'residenceId')] Residence $residence,
        #[MapEntity(id: 'lotId')] Lot $lot
    ): Response {
        try {
            $entityManager->remove($charge);
            $entityManager->flush();
            $this->addFlash('success', 'Charge supprimée');
        } catch (Exception $e) {
            $this->addFlash('error', 'Suppression non possible.');
        }

        return $this->redirectToRoute('app_lot_edit', [
            'residenceId' => $residence->getId(),
            'id' => $lot->getId()
        ], Response::HTTP_SEE_OTHER);
    }
}
