<?php

namespace App\Controller;

use App\Entity\Residence;
use App\Entity\TaxeFonciere;
use App\Form\TaxeFonciereType;
use App\Repository\TaxeFonciereRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/residence/{residenceId}/taxe-fonciere')]
class TaxeFonciereController extends AbstractController
{
    #[Route('/', name: 'app_taxe_fonciere_index', methods: ['GET'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    public function index(TaxeFonciereRepository $taxeFonciereRepository, Residence $residence): Response
    {
        return $this->render('taxe_fonciere/index.html.twig', [
            'taxe_foncieres' => $taxeFonciereRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_taxe_fonciere_new', methods: ['GET', 'POST'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Residence $residence): Response
    {
        $taxeFonciere = new TaxeFonciere();
        $form = $this->createForm(TaxeFonciereType::class, $taxeFonciere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $taxeFonciere->setResidence($residence);
            $entityManager->persist($taxeFonciere);
            $entityManager->flush();

            return $this->redirectToRoute('app_residence_show', [
                'id' => $residence->getId(),
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('taxe_fonciere/new.html.twig', [
            'taxe_fonciere' => $taxeFonciere,
            'form' => $form,
            'residence' => $residence,
        ]);
    }

    #[Route('/{id}', name: 'app_taxe_fonciere_show', methods: ['GET'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    public function show(TaxeFonciere $taxeFonciere): Response
    {
        return $this->render('taxe_fonciere/show.html.twig', [
            'taxe_fonciere' => $taxeFonciere,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_taxe_fonciere_edit', methods: ['GET', 'POST'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    public function edit(Request $request, TaxeFonciere $taxeFonciere, EntityManagerInterface $entityManager, Residence $residence): Response
    {
        $form = $this->createForm(TaxeFonciereType::class, $taxeFonciere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_residence_show', [
                'id' => $residence->getId(),
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('taxe_fonciere/edit.html.twig', [
            'taxe_fonciere' => $taxeFonciere,
            'form' => $form,
            'residence' => $residence
        ]);
    }

    #[Route('/{id}', name: 'app_taxe_fonciere_delete', methods: ['POST'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    public function delete(Request $request, TaxeFonciere $taxeFonciere, EntityManagerInterface $entityManager, Residence $residence): Response
    {
        if ($this->isCsrfTokenValid('delete'.$taxeFonciere->getId(), $request->request->get('_token'))) {
            $entityManager->remove($taxeFonciere);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_residence_show', [
            'id' => $residence->getId()
        ], Response::HTTP_SEE_OTHER);
    }
}
