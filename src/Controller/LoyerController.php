<?php

namespace App\Controller;

use App\Entity\Location;
use App\Entity\Lot;
use App\Entity\Loyer;
use App\Entity\Residence;
use App\Form\LoyerType;
use App\Repository\LoyerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('residence/{residenceId}/lot/{lotId}/location/{locationId}/loyer')]
class LoyerController extends AbstractController
{
    #[Route('/', name: 'app_loyer_index', methods: ['GET'])]
    public function index(
        LoyerRepository $loyerRepository,
        #[MapEntity(id: 'residenceId')] Residence $residence,
        #[MapEntity(id: 'lotId')] Lot $lot,
        #[MapEntity(id: 'locationId')] Location $location
    ): Response
    {
        return $this->render('loyer/index.html.twig', [
            'loyers' => $loyerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_loyer_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        #[MapEntity(id: 'residenceId')] Residence $residence,
        #[MapEntity(id: 'lotId')] Lot $lot,
        #[MapEntity(id: 'locationId')] Location $location,
    ): Response {
        $loyer = new Loyer();
        $form = $this->createForm(LoyerType::class, $loyer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $loyer->setLocation($location);
            $entityManager->persist($loyer);
            $entityManager->flush();

            return $this->redirectToRoute('app_location_edit', [
                'residenceId' => $residence->getId(),
                'lotId' => $lot->getId(),
                'id' => $location->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('loyer/new.html.twig', [
            'loyer' => $loyer,
            'form' => $form,
            'residence' => $residence,
            'lot' => $lot,
            'location' => $location
        ]);
    }

    #[Route('/{id}/edit', name: 'app_loyer_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Loyer $loyer,
        EntityManagerInterface $entityManager,
        #[MapEntity(id: 'residenceId')] Residence $residence,
        #[MapEntity(id: 'lotId')] Lot $lot,
        #[MapEntity(id: 'locationId')] Location $location,
    ): Response {
        $form = $this->createForm(LoyerType::class, $loyer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_location_edit', [
                'residenceId' => $residence->getId(),
                'lotId' => $lot->getId(),
                'id' => $location->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('loyer/edit.html.twig', [
            'loyer' => $loyer,
            'form' => $form,
            'residence' => $residence,
            'lot' => $lot,
            'location' => $location
        ]);
    }

    #[Route('/{id}/delete', name: 'app_loyer_delete', methods: ['GET', 'POST'])]
    public function delete(
        Loyer $loyer,
        EntityManagerInterface $entityManager,
        #[MapEntity(id: 'residenceId')] Residence $residence,
        #[MapEntity(id: 'lotId')] Lot $lot,
        #[MapEntity(id: 'locationId')] Location $location,
    ): Response {
        try {
            $entityManager->remove($loyer);
            $entityManager->flush();
            $this->addFlash('success', 'Loyer supprimé');
        } catch (Exception $e) {
            $this->addFlash('error', 'Suppression non possible.');
        }

        return $this->redirectToRoute('app_location_edit', [
            'residenceId' => $residence->getId(),
            'lotId' => $lot->getId(),
            'id' => $location->getId()
        ], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/duplicate', name: 'app_loyer_duplicate')]
    public function duplicate(
        Loyer $loyer,
        #[MapEntity(id: 'residenceId')] Residence $residence,
        #[MapEntity(id: 'lotId')] Lot $lot,
        #[MapEntity(id: 'locationId')] Location $location,
        EntityManagerInterface $entityManager
    )
    {
        $newloyer = clone $loyer; // Cloner l'objet loyer
        $newloyer->setMois($loyer->getMois() + 1);
        $entityManager->persist($newloyer);
        $entityManager->flush();

        return $this->redirectToRoute('app_location_edit', [
            'residenceId' => $residence->getId(),
            'lotId' => $lot->getId(),
            'id' => $location->getId()
        ], Response::HTTP_SEE_OTHER);
    }
}
