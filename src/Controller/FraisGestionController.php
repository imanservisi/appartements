<?php

namespace App\Controller;

use App\Entity\FraisGestion;
use App\Entity\Lot;
use App\Entity\MandatGestionnaire;
use App\Entity\Residence;
use App\Form\FraisGestionType;
use App\Repository\FraisGestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('residence/{residenceId}/lot/{lotId}/mandatGestionnaire/{mandatGestionnaireId}/fraisGestion')]
class FraisGestionController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em
    )
    {
    }

    #[Route('/', name: 'app_frais_gestion_index', methods: ['GET'])]
    public function index(
        FraisGestionRepository $fraisGestionRepository,
        #[MapEntity(id: 'residenceId')] Residence $residence,
        #[MapEntity(id: 'lotId')] Lot $lot,
        #[MapEntity(id: 'mandatGestionnaireId')] MandatGestionnaire $mandatGestionnaire
    ): Response {
        return $this->render('frais_gestion/index.html.twig', [
            'frais_gestions' => $fraisGestionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_frais_gestion_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        #[MapEntity(id: 'residenceId')] Residence $residence,
        #[MapEntity(id: 'lotId')] Lot $lot,
        #[MapEntity(id: 'mandatGestionnaireId')] MandatGestionnaire $mandatGestionnaire
    ): Response {
        $fraisGestion = new FraisGestion();
        $form = $this->createForm(FraisGestionType::class, $fraisGestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fraisGestion->setMandatGestionnaire($mandatGestionnaire);
            $this->em->persist($fraisGestion);
            $this->em->flush();

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

    #[Route('/{id}/edit', name: 'app_frais_gestion_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        FraisGestion $fraisGestion,
        #[MapEntity(id: 'residenceId')] Residence $residence,
        #[MapEntity(id: 'lotId')] Lot $lot,
        #[MapEntity(id: 'mandatGestionnaireId')] MandatGestionnaire $mandatGestionnaire
    ): Response {
        $form = $this->createForm(FraisGestionType::class, $fraisGestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

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

    #[Route('/{id}/delete', name: 'app_frais_gestion_delete', methods: ['GET', 'POST'])]
    public function delete(
        FraisGestion $fraisGestion,
        #[MapEntity(id: 'residenceId')] Residence $residence,
        #[MapEntity(id: 'lotId')] Lot $lot,
        #[MapEntity(id: 'mandatGestionnaireId')] MandatGestionnaire $mandatGestionnaire
    ): Response {
        try {
            $this->em->remove($fraisGestion);
            $this->em->flush();
            $this->addFlash('success', 'Frais gestion supprimé');
        } catch (Exception $e) {
            $this->addFlash('error', 'Suppression non possible.');
        }

        return $this->redirectToRoute('app_mandat_gestionnaire_edit', [
            'residenceId' => $residence->getId(),
            'lotId' => $lot->getId(),
            'id' => $mandatGestionnaire->getId()
        ], Response::HTTP_SEE_OTHER);
    }
}
