<?php

namespace App\Controller;

use App\Entity\CoverLetter;
use App\Entity\JobOffer;
use App\Repository\CoverLetterRepository;
use App\Repository\JobOfferRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoverLetterController extends AbstractController
{
    #[Route('/cover-letter', name: 'app_cover_letter', methods: ['GET'])]
    public function index(JobOfferRepository $jr, UserRepository $ur): Response
    {

        $$jobOffer = $jr->findAll();
        $users = $ur->findAll();
        return $this->render('cover_letter/index.html.twig', [

            'users' => $users,
            'user' => $user,
            'jobOffer' => $jobOffer,
        ]);
        dd($cover_letters);
        // return $this->render('cover_letter/index.html.twig', [
        //     'cover_letters' => $cr->findBy(['app_user' => $this->getUser()]),
        // ]);
    }

    #[Route('/cover-letter/{id}', name: 'app_cover_letter_show', methods: ['GET'])]
    public function show(CoverLetter $coverLetter): Response
    {
        return $this->render('cover_letter/show.html.twig', [
            'cover_letter' => $coverLetter,
        ]);
    }
}
