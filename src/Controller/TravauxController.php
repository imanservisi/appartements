<?php

namespace App\Controller;

use App\Entity\Lot;
use App\Entity\Residence;
use App\Entity\Travaux;
use App\Form\TravauxType;
use App\Repository\TravauxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('residence/{residenceId}/lot/{lotId}/travaux')]
class TravauxController extends AbstractController
{
    #[Route('/', name: 'app_travaux_index', methods: ['GET'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    #[ParamConverter('lot', options: ['id' => 'lotId'])]
    public function index(TravauxRepository $travauxRepository): Response
    {
        return $this->render('travaux/index.html.twig', [
            'travauxes' => $travauxRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_travaux_new', methods: ['GET', 'POST'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    #[ParamConverter('lot', options: ['id' => 'lotId'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        Residence $residence,
        Lot $lot
    ): Response {
        $travaux = new Travaux();
        $form = $this->createForm(TravauxType::class, $travaux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $travaux->setLot($lot);
            $entityManager->persist($travaux);
            $entityManager->flush();

            return $this->redirectToRoute('app_lot_edit', [
                'residenceId' => $residence->getId(),
                'id' => $lot->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('travaux/new.html.twig', [
            'travaux' => $travaux,
            'form' => $form,
            'residence' => $residence,
            'lot' => $lot
        ]);
    }

    #[Route('/{id}/edit', name: 'app_travaux_edit', methods: ['GET', 'POST'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    #[ParamConverter('lot', options: ['id' => 'lotId'])]
    public function edit(
        Request $request,
        Travaux $travaux,
        EntityManagerInterface $entityManager,
        Residence $residence,
        Lot $lot
    ): Response {
        $form = $this->createForm(TravauxType::class, $travaux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_lot_edit', [
                'residenceId' => $residence->getId(),
                'id' => $lot->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('travaux/edit.html.twig', [
            'travaux' => $travaux,
            'form' => $form,
            'residence' => $residence,
            'lot' => $lot
        ]);
    }

    #[Route('/{id}/delete', name: 'app_travaux_delete', methods: ['GET', 'POST'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    #[ParamConverter('lot', options: ['id' => 'lotId'])]
    public function delete(
        Travaux $travaux,
        EntityManagerInterface $entityManager,
        Residence $residence,
        Lot $lot
    ): Response {
        try {
            $entityManager->remove($travaux);
            $entityManager->flush();
            $this->addFlash('success', 'Travaux supprimés');
        } catch (Exception $e) {
            $this->addFlash('error', 'Suppression non possible.');
        }

        return $this->redirectToRoute('app_lot_edit', [
            'residenceId' => $residence->getId(),
            'id' => $lot->getId()
        ], Response::HTTP_SEE_OTHER);
    }
}
