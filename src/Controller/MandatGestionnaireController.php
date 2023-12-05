<?php

namespace App\Controller;

use App\Entity\Lot;
use App\Entity\MandatGestionnaire;
use App\Entity\Residence;
use App\Form\MandatGestionnaireType;
use App\Repository\FraisGestionRepository;
use App\Repository\MandatGestionnaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('residence/{residenceId}/lot/{lotId}/mandatGestionnaire')]
class MandatGestionnaireController extends AbstractController
{
    #[Route('/', name: 'app_mandat_gestionnaire_index', methods: ['GET'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    #[ParamConverter('lot', options: ['id' => 'lotId'])]
    public function index(MandatGestionnaireRepository $mandatGestionnaireRepository, Residence $residence, Lot $lot): Response
    {
        $mandatGestionnaires = $mandatGestionnaireRepository->findBy(['lot' => $lot]);
        return $this->render('mandat_gestionnaire/index.html.twig', [
            'mandat_gestionnaires' => $mandatGestionnaires,
            'residence' => $residence,
            'lot' => $lot
        ]);
    }

    #[Route('/new', name: 'app_mandat_gestionnaire_new', methods: ['GET', 'POST'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    #[ParamConverter('lot', options: ['id' => 'lotId'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        Residence $residence,
        Lot $lot
        ): Response {
        $mandatGestionnaire = new MandatGestionnaire();
        $form = $this->createForm(MandatGestionnaireType::class, $mandatGestionnaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mandatGestionnaire->setLot($lot);
            $entityManager->persist($mandatGestionnaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_lot_edit', [
                'residenceId' => $residence->getId(),
                'id' => $lot->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('mandat_gestionnaire/new.html.twig', [
            'mandat_gestionnaire' => $mandatGestionnaire,
            'form' => $form,
            'residence' => $residence,
            'lot' => $lot
        ]);
    }

    #[Route('/{id}', name: 'app_mandat_gestionnaire_show', methods: ['GET'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    #[ParamConverter('lot', options: ['id' => 'lotId'])]
    public function show(MandatGestionnaire $mandatGestionnaire): Response
    {
        return $this->render('mandat_gestionnaire/show.html.twig', [
            'mandat_gestionnaire' => $mandatGestionnaire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_mandat_gestionnaire_edit', methods: ['GET', 'POST'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    #[ParamConverter('lot', options: ['id' => 'lotId'])]
    public function edit(
        Request $request,
        MandatGestionnaire $mandatGestionnaire,
        EntityManagerInterface $entityManager,
        Residence $residence,
        Lot $lot,
        FraisGestionRepository $fraisGestionRepository
        ): Response {
        //Récupération des frais de gestion liés au mandat
        $frais_gestions = $fraisGestionRepository->findBy(['mandatGestionnaire' => $mandatGestionnaire]);
        $form = $this->createForm(MandatGestionnaireType::class, $mandatGestionnaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_lot_edit', [
                'residenceId' => $residence->getId(),
                'id' => $lot->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('mandat_gestionnaire/edit.html.twig', [
            'mandat_gestionnaire' => $mandatGestionnaire,
            'form' => $form,
            'residence' => $residence,
            'lot' => $lot,
            'frais_gestions' => $frais_gestions
        ]);
    }

    #[Route('/{id}/delete', name: 'app_mandat_gestionnaire_delete', methods: ['GET', 'POST'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    #[ParamConverter('lot', options: ['id' => 'lotId'])]
    public function delete(
        Request $request,
        MandatGestionnaire $mandatGestionnaire,
        EntityManagerInterface $entityManager,
        Residence $residence,
        Lot $lot
    ): Response {
        if ($this->isCsrfTokenValid('delete'.$mandatGestionnaire->getId(), $request->request->get('_token'))) {
            $entityManager->remove($mandatGestionnaire);
            $entityManager->flush();
        }
        try {
            $entityManager->remove($mandatGestionnaire);
            $entityManager->flush();
            $this->addFlash('success', 'Mandat gestionnaire supprimé');
        } catch (Exception $e) {
            $this->addFlash('error', 'Suppression non possible.');
        }

        return $this->redirectToRoute('app_lot_edit', [
            'residenceId' => $residence->getId(),
            'id' => $lot->getId()
        ], Response::HTTP_SEE_OTHER);
    }
}
