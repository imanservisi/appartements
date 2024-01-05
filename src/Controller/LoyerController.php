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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('residence/{residenceId}/lot/{lotId}/location/{locationId}/loyer')]
class LoyerController extends AbstractController
{
    #[Route('/', name: 'app_loyer_index', methods: ['GET'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    #[ParamConverter('lot', options: ['id' => 'lotId'])]
    #[ParamConverter('location', options: ['id' => 'locationId'])]
    public function index(LoyerRepository $loyerRepository): Response
    {
        return $this->render('loyer/index.html.twig', [
            'loyers' => $loyerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_loyer_new', methods: ['GET', 'POST'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    #[ParamConverter('lot', options: ['id' => 'lotId'])]
    #[ParamConverter('location', options: ['id' => 'locationId'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        Residence $residence,
        Lot $lot,
        Location $location
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
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    #[ParamConverter('lot', options: ['id' => 'lotId'])]
    #[ParamConverter('location', options: ['id' => 'locationId'])]
    public function edit(
        Request $request,
        Loyer $loyer,
        EntityManagerInterface $entityManager,
        Residence $residence,
        Lot $lot,
        Location $location
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
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    #[ParamConverter('lot', options: ['id' => 'lotId'])]
    #[ParamConverter('location', options: ['id' => 'locationId'])]
    public function delete(
        Loyer $loyer,
        EntityManagerInterface $entityManager,
        Residence $residence,
        Lot $lot,
        Location $location
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
}
