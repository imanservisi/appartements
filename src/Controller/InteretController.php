<?php

namespace App\Controller;

use App\Entity\Emprunt;
use App\Entity\Interet;
use App\Entity\Lot;
use App\Entity\Residence;
use App\Form\InteretType;
use App\Repository\InteretRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('residence/{residenceId}/lot/{lotId}/emprunt/{empruntId}/interet')]
class InteretController extends AbstractController
{
    #[Route('/', name: 'app_interet_index', methods: ['GET'])]
    public function index(
        InteretRepository $interetRepository,
        #[MapEntity(id: 'residenceId')] Residence $residence,
        #[MapEntity(id: 'lotId')] Lot $lot,
        #[MapEntity(id: 'empruntId')] Emprunt $emprunt
    ): Response {
        return $this->render('interet/index.html.twig', [
            'interets' => $interetRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_interet_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        #[MapEntity(id: 'residenceId')] Residence $residence,
        #[MapEntity(id: 'lotId')] Lot $lot,
        #[MapEntity(id: 'empruntId')] Emprunt $emprunt
    ): Response {
        $interet = new Interet();
        $form = $this->createForm(InteretType::class, $interet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $interet->setEmprunt($emprunt);
            $entityManager->persist($interet);
            $entityManager->flush();

            return $this->redirectToRoute('app_emprunt_edit', [
                'residenceId' => $residence->getId(),
                'lotId' => $lot->getId(),
                'id' => $emprunt->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('interet/new.html.twig', [
            'interet' => $interet,
            'form' => $form,
            'residence' => $residence,
            'lot' => $lot,
            'emprunt' => $emprunt
        ]);
    }

    #[Route('/{id}/edit', name: 'app_interet_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Interet $interet,
        EntityManagerInterface $entityManager,
        #[MapEntity(id: 'residenceId')] Residence $residence,
        #[MapEntity(id: 'lotId')] Lot $lot,
        #[MapEntity(id: 'empruntId')] Emprunt $emprunt
    ): Response {
        $form = $this->createForm(InteretType::class, $interet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_emprunt_edit', [
                'residenceId' => $residence->getId(),
                'lotId' => $lot->getId(),
                'id' => $emprunt->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('interet/edit.html.twig', [
            'interet' => $interet,
            'form' => $form,
            'residence' => $residence,
            'lot' => $lot,
            'emprunt' => $emprunt
        ]);
    }

    #[Route('/{id}/delete', name: 'app_interet_delete', methods: ['GET', 'POST'])]
    public function delete(
        Interet $interet,
        EntityManagerInterface $entityManager,
        #[MapEntity(id: 'residenceId')] Residence $residence,
        #[MapEntity(id: 'lotId')] Lot $lot,
        #[MapEntity(id: 'empruntId')] Emprunt $emprunt
    ): Response {
        try {
            $entityManager->remove($interet);
            $entityManager->flush();
            $this->addFlash('success', 'Intérêt supprimé');
        } catch (Exception $e) {
            $this->addFlash('error', 'Suppression non possible.');
        }

        return $this->redirectToRoute('app_emprunt_edit', [
            'residenceId' => $residence->getId(),
            'lotId' => $lot->getId(),
            'id' => $emprunt->getId()
        ], Response::HTTP_SEE_OTHER);
    }
}
