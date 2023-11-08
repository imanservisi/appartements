<?php

namespace App\Controller;

use App\Entity\FraisGestion;
use App\Entity\Lot;
use App\Entity\MandatGestionnaire;
use App\Entity\Residence;
use App\Form\FraisGestionType;
use App\Repository\FraisGestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('residence/{residenceId}/lot/{lotId}/mandatGestionnaire/{mandatGestionnaireId}/fraisGestion')]
class FraisGestionController extends AbstractController
{
    #[Route('/', name: 'app_frais_gestion_index', methods: ['GET'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    #[ParamConverter('lot', options: ['id' => 'lotId'])]
    public function index(FraisGestionRepository $fraisGestionRepository, Residence $residence, Lot $lot): Response
    {
        return $this->render('frais_gestion/index.html.twig', [
            'frais_gestions' => $fraisGestionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_frais_gestion_new', methods: ['GET', 'POST'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    #[ParamConverter('lot', options: ['id' => 'lotId'])]
    #[ParamConverter('mandatGestionnaire', options: ['id' => 'mandatGestionnaireId'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        Residence $residence,
        Lot $lot,
        MandatGestionnaire $mandatGestionnaire
        ): Response {
        $fraisGestion = new FraisGestion();
        $form = $this->createForm(FraisGestionType::class, $fraisGestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fraisGestion->setMandatGestionnaire($mandatGestionnaire);
            $entityManager->persist($fraisGestion);
            $entityManager->flush();

            return $this->redirectToRoute('app_mandat_gestionnaire_edit', [
                'residenceId' => $residence->getId(),
                'lotId' => $lot->getId(),
                'id' => $mandatGestionnaire->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('frais_gestion/new.html.twig', [
            'frais_gestion' => $fraisGestion,
            'form' => $form,
            'residence' => $residence,
            'lot' => $lot,
            'mandat_gestionnaire' => $mandatGestionnaire
        ]);
    }

    #[Route('/{id}', name: 'app_frais_gestion_show', methods: ['GET'])]
    public function show(FraisGestion $fraisGestion): Response
    {
        return $this->render('frais_gestion/show.html.twig', [
            'frais_gestion' => $fraisGestion,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_frais_gestion_edit', methods: ['GET', 'POST'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    #[ParamConverter('lot', options: ['id' => 'lotId'])]
    #[ParamConverter('mandatGestionnaire', options: ['id' => 'mandatGestionnaireId'])]
    public function edit(
        Request $request,
        FraisGestion $fraisGestion,
        EntityManagerInterface $entityManager,
        Residence $residence,
        Lot $lot,
        MandatGestionnaire $mandatGestionnaire
        ): Response {
        $form = $this->createForm(FraisGestionType::class, $fraisGestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_mandat_gestionnaire_edit', [
                'residenceId' => $residence->getId(),
                'lotId' => $lot->getId(),
                'id' => $mandatGestionnaire->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('frais_gestion/edit.html.twig', [
            'frais_gestion' => $fraisGestion,
            'form' => $form,
            'residence' => $residence,
            'lot' => $lot,
            'mandat_gestionnaire' => $mandatGestionnaire
        ]);
    }

    #[Route('/{id}', name: 'app_frais_gestion_delete', methods: ['POST'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    #[ParamConverter('lot', options: ['id' => 'lotId'])]
    #[ParamConverter('mandatGestionnaire', options: ['id' => 'mandatGestionnaireId'])]
    public function delete(
        Request $request,
        FraisGestion $fraisGestion,
        EntityManagerInterface $entityManager,
        Residence $residence,
        Lot $lot,
        MandatGestionnaire $mandatGestionnaire
        ): Response {
        if ($this->isCsrfTokenValid('delete'.$fraisGestion->getId(), $request->request->get('_token'))) {
            $entityManager->remove($fraisGestion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_mandat_gestionnaire_edit', [
            'residenceId' => $residence->getId(),
            'lotId' => $lot->getId(),
            'id' => $mandatGestionnaire->getId()
        ], Response::HTTP_SEE_OTHER);
    }
}
