<?php

namespace App\Controller\Ifi;

use App\Entity\Ifi\ValeurDeclaree;
use App\Form\Ifi\ValeurDeclareeType;
use App\Repository\Ifi\ValeurDeclareeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ifi/valeur/declaree')]
final class ValeurDeclareeController extends AbstractController
{
    #[Route(name: 'app_ifi_valeur_declaree_index', methods: ['GET'])]
    public function index(ValeurDeclareeRepository $valeurDeclareeRepository): Response
    {
        return $this->render('ifi/valeur_declaree/index.html.twig', [
            'valeur_declarees' => $valeurDeclareeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ifi_valeur_declaree_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $valeurDeclaree = new ValeurDeclaree();
        $form = $this->createForm(ValeurDeclareeType::class, $valeurDeclaree);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($valeurDeclaree);
            $entityManager->flush();

            return $this->redirectToRoute('app_ifi_valeur_declaree_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ifi/valeur_declaree/new.html.twig', [
            'valeur_declaree' => $valeurDeclaree,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ifi_valeur_declaree_show', methods: ['GET'])]
    public function show(ValeurDeclaree $valeurDeclaree): Response
    {
        return $this->render('ifi/valeur_declaree/show.html.twig', [
            'valeur_declaree' => $valeurDeclaree,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ifi_valeur_declaree_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ValeurDeclaree $valeurDeclaree, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ValeurDeclareeType::class, $valeurDeclaree);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ifi_valeur_declaree_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ifi/valeur_declaree/edit.html.twig', [
            'valeur_declaree' => $valeurDeclaree,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ifi_valeur_declaree_delete', methods: ['POST'])]
    public function delete(Request $request, ValeurDeclaree $valeurDeclaree, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$valeurDeclaree->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($valeurDeclaree);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ifi_valeur_declaree_index', [], Response::HTTP_SEE_OTHER);
    }
}
