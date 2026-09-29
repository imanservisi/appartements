<?php

namespace App\Controller\Ifi;

use App\Entity\Travaux;
use App\Form\TravauxType;
use App\Repository\TravauxRepository;
use App\Service\DeclarationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route("/ifi")]
final class TravauxIfiController extends AbstractController
{
    #[Route('/travaux', name: 'app_ifi_travaux')]
    public function index(
        Request $request,
        DeclarationService $declarationService,
        TravauxRepository $travauxRepository,
    ): Response
    {
        $annees = $declarationService->createYearsArray();
        $anneeChoisie = $request->request->get('choix-annee', date('Y', strtotime('-1 year')));

        $travaux = $travauxRepository->findBy(['annee' => $anneeChoisie]);

        return $this->render('ifi/travaux_ifi/index.html.twig', [
            'annees' => $annees,
            'annee_choisie' => $anneeChoisie,
            'travaux' => $travaux
        ]);
    }

    #[Route("/travaux/new", name: 'app_ifi_travaux_new', methods: ['GET', 'POST'])]
    public function newWithoutLot(
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response
    {
        $travaux = new Travaux();
        $form = $this->createForm(TravauxType::class, $travaux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($travaux);
            $entityManager->flush();
            return $this->redirectToRoute('app_ifi_travaux');
        }

        return $this->render('travaux/new.html.twig', [
            'travaux' => $travaux,
            'form' => $form,
        ]);
    }

    #[Route("/travaux/{id}/edit", name: 'app_ifi_travaux_edit', methods: ['GET', 'POST'])]
    public function updateWithoutLot(
        Request $request,
        Travaux $travaux,
        EntityManagerInterface $entityManager,
    ): Response
    {
        $form = $this->createForm(TravauxType::class, $travaux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ifi_travaux');
        }

        return $this->render('travaux/edit.html.twig', [
            'travaux' => $travaux,
            'form' => $form,
        ]);
    }

    #[Route("/travaux/{id}", name: 'app_ifi_travaux_delete', methods: ['POST'])]
    public function deleteWithoutLot(
        Request $request,
        Travaux $travaux,
        EntityManagerInterface $entityManager
    ): Response
    {
        if ($this->isCsrfTokenValid('delete'.$travaux->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($travaux);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ifi_travaux', [], Response::HTTP_SEE_OTHER);
    }
}
