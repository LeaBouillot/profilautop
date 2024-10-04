<?php

namespace App\Controller;

use App\Entity\JobOffer;
use App\Form\JobOfferType;
use App\Repository\JobOfferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

 // #[IsGranted('ROLE_USER')]
class JobOfferController extends AbstractController
{
    #[Route('/job-offers', name: 'app_job_offer_list', methods: ['GET'])]
    public function list(JobOfferRepository $jr): Response
    {
        $jobOffers = $jr->findAll();
        return $this->render('job_offer/list.html.twig', [
             'jobOffers' => $jobOffers
        ]);
    }

     #[Route('/job-offers/new', name: 'app_job_offer_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $jobOffer = new JobOffer();
        $form = $this->createForm(JobOfferType::class, $jobOffer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($jobOffer);
            $entityManager->flush();

            return $this->redirectToRoute('app_job_offer_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('job_offer/new.html.twig', [
            'job_offer' => $jobOffer,
            'form' => $form,
        ]);
    }

    #[Route('/job-offers/{id}', name: 'app_job_offer_show', methods: ['GET'])]
    public function show(JobOffer $jobOffer, JobOfferRepository $jr, int $id): Response
    {    //dd($jobOffer); // to debug, remove this line when you're ready
        //dd($jr); 
        $jobOffer = $jr->find($id);
        return $this->render('job_offer/show.html.twig', [
            'job_offer' => $jobOffer,
            'id' => $jobOffer->getId(),
        ]);
        dd($jobOffer);
    }

    #[Route('/{id}/edit', name: 'app_job_offer_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, JobOffer $jobOffer, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(JobOfferType::class, $jobOffer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_job_offer_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('job_offer/edit.html.twig', [
            'job_offer' => $jobOffer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_job_offer_delete', methods: ['POST'])]
    public function delete(Request $request, JobOffer $jobOffer, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $jobOffer->getId(), $request->request->get('_token'))) {
            $entityManager->remove($jobOffer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_job_offer_list', [], Response::HTTP_SEE_OTHER);
    }
}
