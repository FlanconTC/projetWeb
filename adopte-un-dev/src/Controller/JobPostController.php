<?php

namespace App\Controller;

use App\Entity\JobPost;
use App\Form\JobPostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobPostController extends AbstractController
{
    #[Route('/job-post/new', name: 'job_post_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $jobPost = new JobPost();
        $form = $this->createForm(JobPostType::class, $jobPost);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($jobPost);
            $entityManager->flush();

            $this->addFlash('success', 'Fiche de poste créée avec succès.');

            return $this->redirectToRoute('job_post_list');
        }

        return $this->render('job_post/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/job-post/list', name: 'job_post_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $jobPosts = $entityManager->getRepository(JobPost::class)->findAll();

        return $this->render('job_post/list.html.twig', [
            'jobPosts' => $jobPosts,
        ]);
    }

}
