<?php

namespace App\Controller;

use App\Entity\MandatSyndic;
use App\Entity\Residence;
use App\Form\MandatSyndicType;
use App\Repository\MandatSyndicRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/residence/{residenceId}/mandat-syndic')]
class MandatSyndicController extends AbstractController
{
    #[Route('/', name: 'app_mandat_syndic_index', methods: ['GET'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    public function index(MandatSyndicRepository $mandatSyndicRepository, Residence $residence): Response
    {
        return $this->render('mandat_syndic/index.html.twig', [
            'mandat_syndics' => $mandatSyndicRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_mandat_syndic_new', methods: ['GET', 'POST'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Residence $residence): Response
    {
        $mandatSyndic = new MandatSyndic();
        $form = $this->createForm(MandatSyndicType::class, $mandatSyndic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mandatSyndic->setResidence($residence);
            $entityManager->persist($mandatSyndic);
            $entityManager->flush();

            return $this->redirectToRoute('app_residence_show', [
                'id' => $residence->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('mandat_syndic/new.html.twig', [
            'mandat_syndic' => $mandatSyndic,
            'form' => $form,
            'residence' => $residence
        ]);
    }

    // #[Route('/{id}', name: 'app_mandat_syndic_show', methods: ['GET'])]
    // #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    // public function show(MandatSyndic $mandatSyndic): Response
    // {
    //     return $this->render('mandat_syndic/show.html.twig', [
    //         'mandat_syndic' => $mandatSyndic,
    //     ]);
    // }

    #[Route('/{id}/edit', name: 'app_mandat_syndic_edit', methods: ['GET', 'POST'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    public function edit(Request $request, MandatSyndic $mandatSyndic, EntityManagerInterface $entityManager, Residence $residence): Response
    {
        $form = $this->createForm(MandatSyndicType::class, $mandatSyndic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_residence_show', [
                'id' => $residence->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('mandat_syndic/edit.html.twig', [
            'mandat_syndic' => $mandatSyndic,
            'form' => $form,
            'residence' => $residence
        ]);
    }

    #[Route('/{id}/delete', name: 'app_mandat_syndic_delete', methods: ['GET', 'POST'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    public function delete(MandatSyndic $mandatSyndic, EntityManagerInterface $entityManager, Residence $residence): Response
    {
        try {
            $entityManager->remove($mandatSyndic);
            $entityManager->flush();
            $this->addFlash('success', 'Mandat syndic supprimé');
        } catch (Exception $e) {
            $this->addFlash('error', 'Suppression non possible.');
        }

        return $this->redirectToRoute('app_residence_show', [
            'id' => $residence->getId()
        ], Response::HTTP_SEE_OTHER);
    }
}
