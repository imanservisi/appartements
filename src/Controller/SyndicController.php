<?php

namespace App\Controller;

use App\Entity\Syndic;
use App\Form\SyndicType;
use App\Repository\SyndicRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/syndic')]
class SyndicController extends AbstractController
{
    #[Route('/', name: 'app_syndic_index', methods: ['GET'])]
    public function index(SyndicRepository $syndicRepository): Response
    {
        return $this->render('syndic/index.html.twig', [
            'syndics' => $syndicRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_syndic_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $syndic = new Syndic();
        $form = $this->createForm(SyndicType::class, $syndic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($syndic);
            $entityManager->flush();

            return $this->redirectToRoute('app_syndic_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('syndic/new.html.twig', [
            'syndic' => $syndic,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_syndic_show', methods: ['GET'])]
    public function show(Syndic $syndic): Response
    {
        return $this->render('syndic/show.html.twig', [
            'syndic' => $syndic,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_syndic_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Syndic $syndic, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SyndicType::class, $syndic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_syndic_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('syndic/edit.html.twig', [
            'syndic' => $syndic,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_syndic_delete', methods: ['POST'])]
    public function delete(Request $request, Syndic $syndic, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$syndic->getId(), $request->request->get('_token'))) {
            $entityManager->remove($syndic);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_syndic_index', [], Response::HTTP_SEE_OTHER);
    }
}
