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
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('residence/{residenceId}/lot/{lotId}/mandatGestionnaire')]
class MandatGestionnaireController extends AbstractController
{
    private string $domainName;

    public function __construct(string $domainName)
    {
        $this->domainName = $domainName;
    }

    #[Route('/', name: 'app_mandat_gestionnaire_index', methods: ['GET'])]
    public function index(
        MandatGestionnaireRepository $mandatGestionnaireRepository,
        #[MapEntity(id: 'residenceId')] Residence $residence,
        #[MapEntity(id: 'lotId')] Lot $lot
    ): Response {
        $mandatGestionnaires = $mandatGestionnaireRepository->findBy(['lot' => $lot]);
        return $this->render('mandat_gestionnaire/index.html.twig', [
            'mandat_gestionnaires' => $mandatGestionnaires,
            'residence' => $residence,
            'lot' => $lot
        ]);
    }

    #[Route('/new', name: 'app_mandat_gestionnaire_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        #[MapEntity(id: 'residenceId')] Residence $residence,
        #[MapEntity(id: 'lotId')] Lot $lot
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

    #[Route('/{id}/edit', name: 'app_mandat_gestionnaire_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        MandatGestionnaire $mandatGestionnaire,
        EntityManagerInterface $entityManager,
        #[MapEntity(id: 'residenceId')] Residence $residence,
        #[MapEntity(id: 'lotId')] Lot $lot,
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
            'frais_gestions' => $frais_gestions,
            'domain_name' => $this->domainName
        ]);
    }

    #[Route('/{id}/delete', name: 'app_mandat_gestionnaire_delete', methods: ['GET', 'POST'])]
    public function delete(
        MandatGestionnaire $mandatGestionnaire,
        EntityManagerInterface $entityManager,
        #[MapEntity(id: 'residenceId')] Residence $residence,
        #[MapEntity(id: 'lotId')] Lot $lot
    ): Response {
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
