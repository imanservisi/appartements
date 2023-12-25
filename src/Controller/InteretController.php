<?php

namespace App\Controller;

use App\Entity\Emprunt;
use App\Entity\Interet;
use App\Entity\Lot;
use App\Entity\Residence;
use App\Form\InteretType;
use App\Repository\InteretRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('residence/{residenceId}/lot/{lotId}/emprunt/{empruntId}/interet')]
class InteretController extends AbstractController
{
    #[Route('/', name: 'app_interet_index', methods: ['GET'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    #[ParamConverter('lot', options: ['id' => 'lotId'])]
    #[ParamConverter('emprunt', options: ['id' => 'empruntId'])]
    public function index(InteretRepository $interetRepository): Response
    {
        return $this->render('interet/index.html.twig', [
            'interets' => $interetRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_interet_new', methods: ['GET', 'POST'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    #[ParamConverter('lot', options: ['id' => 'lotId'])]
    #[ParamConverter('emprunt', options: ['id' => 'empruntId'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        Residence $residence,
        Lot $lot,
        Emprunt $emprunt    
    ): Response {
        $interet = new Interet();
        $form = $this->createForm(InteretType::class, $interet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $interet->setEmprunt($emprunt);
            $entityManager->persist($interet);
            $entityManager->flush();

            return $this->redirectToRoute('app_emprunt_edit', [
                'residenceId' => $residence->getId(),
                'lotId' => $lot->getId(),
                'id' => $emprunt->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('interet/new.html.twig', [
            'interet' => $interet,
            'form' => $form,
            'residence' => $residence,
            'lot' => $lot,
            'emprunt' => $emprunt
        ]);
    }

    #[Route('/{id}/edit', name: 'app_interet_edit', methods: ['GET', 'POST'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    #[ParamConverter('lot', options: ['id' => 'lotId'])]
    #[ParamConverter('emprunt', options: ['id' => 'empruntId'])]
    public function edit(
        Request $request,
        Interet $interet,
        EntityManagerInterface $entityManager,
        Residence $residence,
        Lot $lot,
        Emprunt $emprunt  
    ): Response {
        $form = $this->createForm(InteretType::class, $interet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_emprunt_edit', [
                'residenceId' => $residence->getId(),
                'lotId' => $lot->getId(),
                'id' => $emprunt->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('interet/edit.html.twig', [
            'interet' => $interet,
            'form' => $form,
            'residence' => $residence,
            'lot' => $lot,
            'emprunt' => $emprunt
        ]);
    }

    #[Route('/{id}/delete', name: 'app_interet_delete', methods: ['GET', 'POST'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    #[ParamConverter('lot', options: ['id' => 'lotId'])]
    #[ParamConverter('emprunt', options: ['id' => 'empruntId'])]
    public function delete(
        Interet $interet,
        EntityManagerInterface $entityManager,
        Residence $residence,
        Lot $lot,
        Emprunt $emprunt  
    ): Response {
        try {
            $entityManager->remove($interet);
            $entityManager->flush();
            $this->addFlash('success', 'Intérêt supprimé');
        } catch (Exception $e) {
            $this->addFlash('error', 'Suppression non possible.');
        }

        return $this->redirectToRoute('app_emprunt_edit', [
            'residenceId' => $residence->getId(),
            'lotId' => $lot->getId(),
            'id' => $emprunt->getId()
        ], Response::HTTP_SEE_OTHER);
    }
}
