<?php

namespace App\Controller;

use App\Repository\JobOfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class JobOfferController extends AbstractController
{
    #[Route('/job-offers', name: 'app_job_offer', methods: ['GET'])]
    public function list(JobOfferRepository $jr): Response
    {
          $user = $this->getUser();
          $jobOffers = $jr->findBy(['app_user' => $user]);
          return $this->render('job_offer/list.html.twig', [
              'jobOffers' => $jobOffers,
          ]);
    }
}
