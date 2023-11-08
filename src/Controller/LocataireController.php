<?php

namespace App\Controller;

use App\Entity\Locataire;
use App\Form\LocataireType;
use App\Repository\LocataireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/locataire')]
class LocataireController extends AbstractController
{
    #[Route('/', name: 'app_locataire_index', methods: ['GET'])]
    public function index(LocataireRepository $locataireRepository): Response
    {
        return $this->render('locataire/index.html.twig', [
            'locataires' => $locataireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_locataire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $locataire = new Locataire();
        $form = $this->createForm(LocataireType::class, $locataire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($locataire);
            $entityManager->flush();

            return $this->redirectToRoute('app_locataire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('locataire/new.html.twig', [
            'locataire' => $locataire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_locataire_show', methods: ['GET'])]
    public function show(Locataire $locataire): Response
    {
        return $this->render('locataire/show.html.twig', [
            'locataire' => $locataire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_locataire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Locataire $locataire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LocataireType::class, $locataire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_locataire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('locataire/edit.html.twig', [
            'locataire' => $locataire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_locataire_delete', methods: ['POST'])]
    public function delete(Request $request, Locataire $locataire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$locataire->getId(), $request->request->get('_token'))) {
            $entityManager->remove($locataire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_locataire_index', [], Response::HTTP_SEE_OTHER);
    }
}
