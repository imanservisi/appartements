<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DeclarationIFIController extends AbstractController
{
    #[Route('/declarationIfi', name: 'app_declaration_ifi')]
    public function index(): Response
    {
        return $this->render('declaration_ifi/index.html.twig', [
            'controller_name' => 'DeclarationIFIController',
        ]);
    }
}
