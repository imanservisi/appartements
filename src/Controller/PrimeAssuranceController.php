<?php

namespace App\Controller;

use App\Entity\Lot;
use App\Entity\PrimeAssurance;
use App\Entity\Residence;
use App\Form\PrimeAssuranceType;
use App\Repository\PrimeAssuranceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('residence/{residenceId}/lot/{lotId}/prime-assurance')]
class PrimeAssuranceController extends AbstractController
{
    #[Route('/', name: 'app_prime_assurance_index', methods: ['GET'])]
    public function index(
        PrimeAssuranceRepository $primeAssuranceRepository,
        #[MapEntity(id: 'residenceId')] Residence $residence,
        #[MapEntity(id: 'lotId')] Lot $lot
    ): Response {
        return $this->render('prime_assurance/index.html.twig', [
            'prime_assurances' => $primeAssuranceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_prime_assurance_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        #[MapEntity(id: 'residenceId')] Residence $residence,
        #[MapEntity(id: 'lotId')] Lot $lot
    ): Response {
        $primeAssurance = new PrimeAssurance();
        $form = $this->createForm(PrimeAssuranceType::class, $primeAssurance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $primeAssurance->setLot($lot);
            $entityManager->persist($primeAssurance);
            $entityManager->flush();

            return $this->redirectToRoute('app_lot_edit', [
                'residenceId' => $residence->getId(),
                'id' => $lot->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('prime_assurance/new.html.twig', [
            'prime_assurance' => $primeAssurance,
            'form' => $form,
            'residence' => $residence,
            'lot' => $lot
        ]);
    }

    #[Route('/{id}', name: 'app_prime_assurance_show', methods: ['GET'])]
    public function show(
        PrimeAssurance $primeAssurance,
        #[MapEntity(id: 'residenceId')] Residence $residence,
        #[MapEntity(id: 'lotId')] Lot $lot
    ): Response {
        return $this->render('prime_assurance/show.html.twig', [
            'prime_assurance' => $primeAssurance,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_prime_assurance_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        PrimeAssurance $primeAssurance,
        EntityManagerInterface $entityManager,
        #[MapEntity(id: 'residenceId')] Residence $residence,
        #[MapEntity(id: 'lotId')] Lot $lot
    ): Response {
        $form = $this->createForm(PrimeAssuranceType::class, $primeAssurance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_lot_edit', [
                'residenceId' => $residence->getId(),
                'id' => $lot->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('prime_assurance/edit.html.twig', [
            'prime_assurance' => $primeAssurance,
            'form' => $form,
            'residence' => $residence,
            'lot' => $lot
        ]);
    }

    #[Route('/{id}/delete', name: 'app_prime_assurance_delete', methods: ['GET', 'POST'])]
    public function delete(
        PrimeAssurance $primeAssurance,
        EntityManagerInterface $entityManager,
        #[MapEntity(id: 'residenceId')] Residence $residence,
        #[MapEntity(id: 'lotId')] Lot $lot
    ): Response {
        try {
            $entityManager->remove($primeAssurance);
            $entityManager->flush();
            $this->addFlash('success', 'Prime supprimée');
        } catch (Exception $e) {
            $this->addFlash('error', 'Suppression non possible.');
        }

        return $this->redirectToRoute('app_lot_edit', [
            'residenceId' => $residence->getId(),
            'id' => $lot->getId()
        ], Response::HTTP_SEE_OTHER);
    }
}
