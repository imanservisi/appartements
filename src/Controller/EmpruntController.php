<?php

namespace App\Controller;

use App\Entity\Emprunt;
use App\Entity\Lot;
use App\Entity\Residence;
use App\Form\EmpruntType;
use App\Repository\EmpruntRepository;
use App\Repository\InteretRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('residence/{residenceId}/lot/{lotId}/emprunt')]
class EmpruntController extends AbstractController
{
    private string $domainName;

    public function __construct(string $domainName)
    {
        $this->domainName = $domainName;
    }

    #[Route('/', name: 'app_emprunt_index', methods: ['GET'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    #[ParamConverter('lot', options: ['id' => 'lotId'])]
    public function index(EmpruntRepository $empruntRepository): Response
    {
        return $this->render('emprunt/index.html.twig', [
            'emprunts' => $empruntRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_emprunt_new', methods: ['GET', 'POST'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    #[ParamConverter('lot', options: ['id' => 'lotId'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        Residence $residence,
        Lot $lot
        ): Response {
        $emprunt = new Emprunt();
        $form = $this->createForm(EmpruntType::class, $emprunt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $emprunt->setLot($lot);
            $entityManager->persist($emprunt);
            $entityManager->flush();

            return $this->redirectToRoute('app_lot_edit', [
                'residenceId' => $residence->getId(),
                'id' => $lot->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('emprunt/new.html.twig', [
            'emprunt' => $emprunt,
            'form' => $form,
            'residence' => $residence,
            'lot' => $lot
        ]);
    }

    #[Route('/{id}/edit', name: 'app_emprunt_edit', methods: ['GET', 'POST'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    #[ParamConverter('lot', options: ['id' => 'lotId'])]
    public function edit(
        Request $request,
        Emprunt $emprunt,
        EntityManagerInterface $entityManager,
        Residence $residence,
        Lot $lot,
        InteretRepository $interetRepository
        ): Response {
        //Récupération des intérêts liés à cet emprunt
        $interets = $interetRepository->findBy(['emprunt' => $emprunt]);

        $form = $this->createForm(EmpruntType::class, $emprunt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_lot_edit', [
                'residenceId' => $residence->getId(),
                'id' => $lot->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('emprunt/edit.html.twig', [
            'emprunt' => $emprunt,
            'form' => $form,
            'residence' => $residence,
            'lot' => $lot,
            'interets' => $interets,
            'domain_name' => $this->domainName
        ]);
    }

    #[Route('/{id}/delete', name: 'app_emprunt_delete', methods: ['GET', 'POST'])]
    #[ParamConverter('residence', options: ['id' => 'residenceId'])]
    #[ParamConverter('lot', options: ['id' => 'lotId'])]
    public function delete(
        Emprunt $emprunt,
        EntityManagerInterface $entityManager,
        Residence $residence,
        Lot $lot
        ): Response {
        try {
            $entityManager->remove($emprunt);
            $entityManager->flush();
            $this->addFlash('success', 'Emprunt supprimé');
        } catch (Exception $e) {
            $this->addFlash('error', 'Suppression non possible.');
        }

        return $this->redirectToRoute('app_lot_edit', [
            'residenceId' => $residence->getId(),
            'id' => $lot->getId()
        ], Response::HTTP_SEE_OTHER);
    }
}
