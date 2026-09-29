<?php

namespace App\Controller\Ifi;

use App\Entity\Ifi\ValeurDette;
use App\Form\Ifi\ValeurDetteType;
use App\Repository\Ifi\ValeurDetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ifi/valeur/dette')]
final class ValeurDetteController extends AbstractController
{
    #[Route(name: 'app_ifi_valeur_dette_index', methods: ['GET'])]
    public function index(ValeurDetteRepository $valeurDetteRepository): Response
    {
        return $this->render('ifi/valeur_dette/index.html.twig', [
            'valeur_dettes' => $valeurDetteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ifi_valeur_dette_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $valeurDette = new ValeurDette();
        $form = $this->createForm(ValeurDetteType::class, $valeurDette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($valeurDette);
            $entityManager->flush();

            return $this->redirectToRoute('app_ifi_valeur_dette_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ifi/valeur_dette/new.html.twig', [
            'valeur_dette' => $valeurDette,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ifi_valeur_dette_show', methods: ['GET'])]
    public function show(ValeurDette $valeurDette): Response
    {
        return $this->render('ifi/valeur_dette/show.html.twig', [
            'valeur_dette' => $valeurDette,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ifi_valeur_dette_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ValeurDette $valeurDette, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ValeurDetteType::class, $valeurDette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ifi_valeur_dette_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ifi/valeur_dette/edit.html.twig', [
            'valeur_dette' => $valeurDette,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ifi_valeur_dette_delete', methods: ['POST'])]
    public function delete(Request $request, ValeurDette $valeurDette, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$valeurDette->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($valeurDette);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ifi_valeur_dette_index', [], Response::HTTP_SEE_OTHER);
    }
}
