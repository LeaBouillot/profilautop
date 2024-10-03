<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegislationController extends AbstractController
{
    #[Route('/register', name: 'app_regislation', methods: ['get', 'post'])]
    public function register(): Response
    {
        return $this->render('regislation/register.html.twig', [
            'controller_name' => 'RegislationController',
        ]);
    }
}
