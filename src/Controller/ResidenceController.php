<?php

namespace App\Controller;

use App\Entity\Residence;
use App\Form\ResidenceType;
use App\Repository\LotRepository;
use App\Repository\MandatSyndicRepository;
use App\Repository\RegularisationPonctuelleRepository;
use App\Repository\ResidenceRepository;
use App\Repository\TaxeFonciereRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/residence')]
class ResidenceController extends AbstractController
{
    private string $domainName;

    public function __construct(string $domainName)
    {
        $this->domainName = $domainName;
    }

    #[Route('/', name: 'app_residence_index', methods: ['GET'])]
    public function index(ResidenceRepository $residenceRepository): Response
    {
        return $this->render('residence/index.html.twig', [
            'residences' => $residenceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_residence_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $residence = new Residence();
        $form = $this->createForm(ResidenceType::class, $residence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($residence);
            $entityManager->flush();

            return $this->redirectToRoute('app_residence_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('residence/new.html.twig', [
            'residence' => $residence,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_residence_show', methods: ['GET'])]
    public function show(
        Residence $residence,
        LotRepository $lotRepository,
        TaxeFonciereRepository $taxeFonciereRepository,
        MandatSyndicRepository $mandatSyndicRepository,
        RegularisationPonctuelleRepository $regularisationPonctuelleRepository
        ): Response {
        //Récupération des lots liés à la résidence
        $lots = $lotRepository->findBy(['residence' => $residence]);
        //récupération de la taxe foncière liée à la résidence
        $taxesFoncieres = $taxeFonciereRepository->findBy(['residence' => $residence]);
        //récupération des mandats des syndics liés à la résidence
        $mandatsSyndic = $mandatSyndicRepository->findBy(['residence' => $residence]);
        // Récupération des régularisations ponctuelles
        $regulsPonctuelles = $regularisationPonctuelleRepository->findBy(['residence' => $residence]);

        return $this->render('residence/show.html.twig', [
            'residence' => $residence,
            'lots' => $lots,
            'taxes_foncieres' => $taxesFoncieres,
            'mandats_syndic' => $mandatsSyndic,
            'domain_name' => $this->domainName,
            'regulsPonctuelles' => $regulsPonctuelles
        ]);
    }

    #[Route('/{id}/edit', name: 'app_residence_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Residence $residence, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ResidenceType::class, $residence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_residence_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('residence/edit.html.twig', [
            'residence' => $residence,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_residence_delete', methods: ['GET','POST'])]
    public function delete(Residence $residence, EntityManagerInterface $entityManager): Response
    {
        try {
            $entityManager->remove($residence);
            $entityManager->flush();
            $this->addFlash('success', 'Résidence supprimée');
        } catch (Exception $e) {
            $this->addFlash('error', 'Suppression non possible.');
        }

        return $this->redirectToRoute('app_residence_index', [], Response::HTTP_SEE_OTHER);
    }
}
