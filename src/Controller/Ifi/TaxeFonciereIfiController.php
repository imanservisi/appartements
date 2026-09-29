<?php

namespace App\Controller\Ifi;

use App\Entity\Ifi\TaxeFonciereIfi;
use App\Form\Ifi\TaxeFonciereIfiType;
use App\Repository\Ifi\TaxeFonciereIfiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ifi/taxe/fonciere/ifi')]
final class TaxeFonciereIfiController extends AbstractController
{
    #[Route(name: 'app_ifi_taxe_fonciere_ifi_index', methods: ['GET'])]
    public function index(TaxeFonciereIfiRepository $taxeFonciereIfiRepository): Response
    {
        return $this->render('ifi/taxe_fonciere_ifi/index.html.twig', [
            'taxe_fonciere_ifis' => $taxeFonciereIfiRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ifi_taxe_fonciere_ifi_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $taxeFonciereIfi = new TaxeFonciereIfi();
        $form = $this->createForm(TaxeFonciereIfiType::class, $taxeFonciereIfi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($taxeFonciereIfi);
            $entityManager->flush();

            return $this->redirectToRoute('app_ifi_taxe_fonciere_ifi_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ifi/taxe_fonciere_ifi/new.html.twig', [
            'taxe_fonciere_ifi' => $taxeFonciereIfi,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ifi_taxe_fonciere_ifi_show', methods: ['GET'])]
    public function show(TaxeFonciereIfi $taxeFonciereIfi): Response
    {
        return $this->render('ifi/taxe_fonciere_ifi/show.html.twig', [
            'taxe_fonciere_ifi' => $taxeFonciereIfi,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ifi_taxe_fonciere_ifi_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TaxeFonciereIfi $taxeFonciereIfi, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TaxeFonciereIfiType::class, $taxeFonciereIfi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ifi_taxe_fonciere_ifi_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ifi/taxe_fonciere_ifi/edit.html.twig', [
            'taxe_fonciere_ifi' => $taxeFonciereIfi,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ifi_taxe_fonciere_ifi_delete', methods: ['POST'])]
    public function delete(Request $request, TaxeFonciereIfi $taxeFonciereIfi, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$taxeFonciereIfi->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($taxeFonciereIfi);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ifi_taxe_fonciere_ifi_index', [], Response::HTTP_SEE_OTHER);
    }
}
