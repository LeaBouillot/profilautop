<?php

namespace App\Controller;

use App\Repository\LinkedInMessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LinkedInMessageController extends AbstractController
{
    #[Route('/linkedin', name: 'app_linkedin_message')]
    public function index(LinkedInMessageRepository $lr): Response
    {
        return $this->render('linkedin_message/index.html.twig', [
            'controller_name' => $lr,
        ]);
    }
}
