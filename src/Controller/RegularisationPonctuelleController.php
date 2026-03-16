<?php

namespace App\Controller;

use App\Entity\RegularisationPonctuelle;
use App\Entity\Residence;
use App\Form\RegularisationPonctuelleType;
use App\Repository\RegularisationPonctuelleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/residence/{residenceId}/regularisationPonctuelle')]
class RegularisationPonctuelleController extends AbstractController
{
    #[Route('/', name: 'app_regularisation_ponctuelle_index', methods: ['GET'])]
    public function index(RegularisationPonctuelleRepository $regularisationPonctuelleRepository): Response
    {
        return $this->render('regularisation_ponctuelle/index.html.twig', [
            'regularisation_ponctuelles' => $regularisationPonctuelleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_regularisation_ponctuelle_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        #[MapEntity(id: 'residenceId')] Residence $residence
    ): Response {
        $regularisationPonctuelle = new RegularisationPonctuelle();
        $form = $this->createForm(RegularisationPonctuelleType::class, $regularisationPonctuelle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $regularisationPonctuelle->setResidence($residence);
            $entityManager->persist($regularisationPonctuelle);
            $entityManager->flush();

            return $this->redirectToRoute('app_residence_show', [
                'id' => $residence->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('regularisation_ponctuelle/new.html.twig', [
            'regularisation_ponctuelle' => $regularisationPonctuelle,
            'form' => $form,
            'residence' => $residence
        ]);
    }

    #[Route('/{id}', name: 'app_regularisation_ponctuelle_show', methods: ['GET'])]
    public function show(
        RegularisationPonctuelle $regularisationPonctuelle,
        #[MapEntity(id: 'residenceId')] Residence $residence
    ): Response {
        return $this->render('regularisation_ponctuelle/show.html.twig', [
            'regularisation_ponctuelle' => $regularisationPonctuelle,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_regularisation_ponctuelle_edit', methods: ['GET', 'POST'])]
    public function edit(
        #[MapEntity(id: 'residenceId')] Residence $residence,
        Request $request,
        RegularisationPonctuelle $regularisationPonctuelle,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(RegularisationPonctuelleType::class, $regularisationPonctuelle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_residence_show', [
                'id' => $residence->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('regularisation_ponctuelle/edit.html.twig', [
            'regularisation_ponctuelle' => $regularisationPonctuelle,
            'form' => $form,
            'residence' => $residence
        ]);
    }

    #[Route('/{id}/delete', name: 'app_regularisation_ponctuelle_delete', methods: ['GET', 'POST'])]
    public function delete(
        #[MapEntity(id: 'residenceId')] Residence $residence,
        RegularisationPonctuelle $regularisationPonctuelle,
        EntityManagerInterface $entityManager
    ): Response {
        try {
            $entityManager->remove($regularisationPonctuelle);
            $entityManager->flush();
            $this->addFlash('success', 'Régularisation supprimée');
        } catch (Exception $e) {
            $this->addFlash('error', 'Suppression non possible');
        }

        return $this->redirectToRoute('app_residence_show', [
                'id' => $residence->getId()
            ], Response::HTTP_SEE_OTHER);
    }
}
