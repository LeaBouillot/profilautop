<?php

namespace App\Controller;

use App\Repository\JobOfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(JobOfferRepository $jr): Response
    {
        $user = $this->getUser();

        $jobOffers = [
            'to_apply' => $jr->findByUserAndStatus($user, 'À postuler'),
            'pending' => $jr->findByUserAndStatus($user, 'En attente'),
            'accepted' => $jr->findByUserAndStatus($user, 'Accepté'),
            'rejected' => $jr->findByUserAndStatus($user, 'Refusé'),
        ];

        return $this->render('dashboard/index.html.twig', [
            'jobOffers' => $jobOffers,
        ]);
    }
}
