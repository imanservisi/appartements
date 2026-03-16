<?php

namespace App\Controller;

use App\Entity\Residence;
use App\Entity\TaxeFonciere;
use App\Form\TaxeFonciereType;
use App\Repository\TaxeFonciereRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/residence/{residenceId}/taxe-fonciere')]
class TaxeFonciereController extends AbstractController
{
    #[Route('/', name: 'app_taxe_fonciere_index', methods: ['GET'])]
    public function index(
        TaxeFonciereRepository $taxeFonciereRepository,
        #[MapEntity(id: 'residenceId')] Residence $residence
    ): Response {
        return $this->render('taxe_fonciere/index.html.twig', [
            'taxe_foncieres' => $taxeFonciereRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_taxe_fonciere_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        #[MapEntity(id: 'residenceId')] Residence $residence
    ): Response {
        $taxeFonciere = new TaxeFonciere();
        $form = $this->createForm(TaxeFonciereType::class, $taxeFonciere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $taxeFonciere->setResidence($residence);
            $entityManager->persist($taxeFonciere);
            $entityManager->flush();

            return $this->redirectToRoute('app_residence_show', [
                'id' => $residence->getId(),
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('taxe_fonciere/new.html.twig', [
            'taxe_fonciere' => $taxeFonciere,
            'form' => $form,
            'residence' => $residence,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_taxe_fonciere_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        TaxeFonciere $taxeFonciere,
        EntityManagerInterface $entityManager,
        #[MapEntity(id: 'residenceId')] Residence $residence
    ): Response {
        $form = $this->createForm(TaxeFonciereType::class, $taxeFonciere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_residence_show', [
                'id' => $residence->getId(),
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('taxe_fonciere/edit.html.twig', [
            'taxe_fonciere' => $taxeFonciere,
            'form' => $form,
            'residence' => $residence
        ]);
    }

    #[Route('/{id}/delete', name: 'app_taxe_fonciere_delete', methods: ['GET', 'POST'])]
    public function delete(
        TaxeFonciere $taxeFonciere,
        EntityManagerInterface $entityManager,
        #[MapEntity(id: 'residenceId')] Residence $residence
    ): Response {
        try {
            $entityManager->remove($taxeFonciere);
            $entityManager->flush();
            $this->addFlash('success', 'Taxe foncière supprimée');
        } catch (Exception $e) {
            $this->addFlash('error', 'Suppression non possible.');
        }

        return $this->redirectToRoute('app_residence_show', [
            'id' => $residence->getId()
        ], Response::HTTP_SEE_OTHER);
    }
}
