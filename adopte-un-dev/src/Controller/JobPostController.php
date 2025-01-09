<?php

namespace App\Controller;

use App\Entity\JobPost;
use App\Form\JobPostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;

class JobPostController extends AbstractController
{
    #[Route('/job-post/new', name: 'job_post_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $jobPost = new JobPost();
    
        // Récupérer l'utilisateur connecté
        $currentUser = $this->getUser();
        if (!$currentUser) {
            $this->addFlash('danger', 'Vous devez être connecté pour créer une fiche de poste.');
            return $this->redirectToRoute('app_login');
        }
    
        // Assigner l'utilisateur connecté comme valeur pour company
        $jobPost->setCompany($currentUser);

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
    public function list(EntityManagerInterface $entityManager, Security $security): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $security->getUser();
    
        // Vérifier si l'utilisateur est connecté
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }
    
        // Récupérer les job posts associés à cet utilisateur
        $jobPosts = $entityManager->getRepository(JobPost::class)->findBy(['company' => $user]);
    
        return $this->render('job_post/list.html.twig', [
            'jobPosts' => $jobPosts,
        ]);
    }

    #[Route('/job-post/edit/{id}', name: 'job_post_edit')]
    public function edit(Request $request, EntityManagerInterface $entityManager, JobPost $jobPost): Response
    {
        $form = $this->createForm(JobPostType::class, $jobPost);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Fiche de poste modifiée avec succès.');

            return $this->redirectToRoute('job_post_list');
        }

        return $this->render('job_post/edit.html.twig', [
            'form' => $form->createView(),
            'jobPost' => $jobPost,
        ]);
    }

    #[Route('/job-post/delete/{id}', name: 'job_post_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $entityManager, JobPost $jobPost): Response
    {
        // Vérification de la validité du token CSRF
        if ($this->isCsrfTokenValid('delete' . $jobPost->getId(), $request->request->get('_token'))) {
            $entityManager->remove($jobPost);
            $entityManager->flush();

            $this->addFlash('success', 'Fiche de poste supprimée avec succès.');
        }

        return $this->redirectToRoute('job_post_list');
    }

}
