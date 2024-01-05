<?php

namespace App\Controller;

use App\Entity\Caf;
use App\Entity\Location;
use App\Entity\Lot;
use App\Entity\Residence;
use App\Form\CafType;
use App\Repository\CafRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('residence/{residenceId}/lot/{lotId}/location/{locationId}/caf')]
class CafController extends AbstractController
{
    #[Route('/', name: 'app_caf_index', methods: ['GET'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    #[ParamConverter('lot', options: ['id' => 'lotId'])]
    #[ParamConverter('location', options: ['id' => 'locationId'])]
    public function index(CafRepository $cafRepository): Response
    {
        return $this->render('caf/index.html.twig', [
            'cafs' => $cafRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_caf_new', methods: ['GET', 'POST'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    #[ParamConverter('lot', options: ['id' => 'lotId'])]
    #[ParamConverter('location', options: ['id' => 'locationId'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        Residence $residence,
        Lot $lot,
        Location $location
    ): Response {
        $caf = new Caf();
        $form = $this->createForm(CafType::class, $caf);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $caf->setLocation($location);
            $entityManager->persist($caf);
            $entityManager->flush();

            return $this->redirectToRoute('app_location_edit', [
                'residenceId' => $residence->getId(),
                'lotId' => $lot->getId(),
                'id' => $location->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('caf/new.html.twig', [
            'caf' => $caf,
            'form' => $form,
            'residence' => $residence,
            'lot' => $lot,
            'location' => $location
        ]);
    }

    #[Route('/{id}/edit', name: 'app_caf_edit', methods: ['GET', 'POST'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    #[ParamConverter('lot', options: ['id' => 'lotId'])]
    #[ParamConverter('location', options: ['id' => 'locationId'])]
    public function edit(
        Request $request,
        Caf $caf,
        EntityManagerInterface $entityManager,
        Residence $residence,
        Lot $lot,
        Location $location
    ): Response {
        $form = $this->createForm(CafType::class, $caf);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_location_edit', [
                'residenceId' => $residence->getId(),
                'lotId' => $lot->getId(),
                'id' => $location->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('caf/edit.html.twig', [
            'caf' => $caf,
            'form' => $form,
            'residence' => $residence,
            'lot' => $lot,
            'location' => $location
        ]);
    }

    #[Route('/{id}/delete', name: 'app_caf_delete', methods: ['GET', 'POST'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    #[ParamConverter('lot', options: ['id' => 'lotId'])]
    #[ParamConverter('location', options: ['id' => 'locationId'])]
    public function delete(
        Caf $caf,
        EntityManagerInterface $entityManager,
        Residence $residence,
        Lot $lot,
        Location $location
    ): Response {
        // if ($this->isCsrfTokenValid('delete'.$caf->getId(), $request->request->get('_token'))) {
        //     $entityManager->remove($caf);
        //     $entityManager->flush();
        // }
        try {
            $entityManager->remove($caf);
            $entityManager->flush();
            $this->addFlash('success', 'CAF supprimée');
        } catch (Exception $e) {
            $this->addFlash('error', 'Suppression non possible.');
        }

        return $this->redirectToRoute('app_location_edit', [
            'residenceId' => $residence->getId(),
            'lotId' => $lot->getId(),
            'id' => $location->getId()
        ], Response::HTTP_SEE_OTHER);
    }
}
