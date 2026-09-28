<?php

namespace App\Controller\Securite;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home_accueil')]
    public function home(): Response
    {
        // Accès à la page d'accueil de l'application pour le choix sur IR et IFI
        return $this->render('securite/home/accueil.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/securite/home', name: 'app_securite_home')]
    public function index(): Response
    {
        return $this->render('securite/home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
