<?php

namespace App\Controller;

use App\Entity\RegularisationPonctuelle;
use App\Entity\Residence;
use App\Form\RegularisationPonctuelleType;
use App\Repository\RegularisationPonctuelleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Residence $residence): Response
    {
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
    public function show(RegularisationPonctuelle $regularisationPonctuelle): Response
    {
        return $this->render('regularisation_ponctuelle/show.html.twig', [
            'regularisation_ponctuelle' => $regularisationPonctuelle,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_regularisation_ponctuelle_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RegularisationPonctuelle $regularisationPonctuelle, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RegularisationPonctuelleType::class, $regularisationPonctuelle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_regularisation_ponctuelle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('regularisation_ponctuelle/edit.html.twig', [
            'regularisation_ponctuelle' => $regularisationPonctuelle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_regularisation_ponctuelle_delete', methods: ['POST'])]
    public function delete(Request $request, RegularisationPonctuelle $regularisationPonctuelle, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$regularisationPonctuelle->getId(), $request->request->get('_token'))) {
            $entityManager->remove($regularisationPonctuelle);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_regularisation_ponctuelle_index', [], Response::HTTP_SEE_OTHER);
    }
}
