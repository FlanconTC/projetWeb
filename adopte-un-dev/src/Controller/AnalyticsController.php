<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UserRepository;
use App\Repository\AnalyticsRepository;
use App\Repository\JobPostRepository;
use App\Entity\Analytics;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class AnalyticsController extends AbstractController
{

    #[Route('/analytics/view_job_post/{id}', name: 'analytics_view_job_post', methods: ['POST'])]
    public function registerViewJobPost(int $id, EntityManagerInterface $entityManager, JobPostRepository $jobPostRepository, AnalyticsRepository $analyticsRepository): JsonResponse
    {
        // Rechercher la fiche de poste par son ID unique
        $jobPost = $jobPostRepository->find($id);

        if (!$jobPost) {
            return new JsonResponse(['error' => 'Fiche de poste introuvable'], Response::HTTP_NOT_FOUND);
        }

        // Vérifier si une entrée Analytics existe déjà
        $analytics = $analyticsRepository->findOneBy(['jobPost' => $jobPost]);

        if (!$analytics) {
            $analytics = new Analytics();
            $analytics->setJobPost($jobPost)
                    ->setViewCount(1)
                    ->setLastViewedAt(new \DateTimeImmutable());
        } else {
            $analytics->setViewCount($analytics->getViewCount() + 1)
                    ->setLastViewedAt(new \DateTimeImmutable());
        }

        $entityManager->persist($analytics);
        $entityManager->flush();

        return new JsonResponse(['success' => true]);
    }

    #[Route('/analytics/view_user/{id}', name: 'analytics_view', methods: ['POST'])]
    public function registerViewUser(int $id, EntityManagerInterface $entityManager, UserRepository $userRepository, JobPostRepository $jobPostRepository, AnalyticsRepository $analyticsRepository): JsonResponse
    {
        $user = $userRepository->find($id);

        if (!$user) {
            return new JsonResponse(['error' => 'Ressource introuvable'], Response::HTTP_NOT_FOUND);
        }

        // Rechercher ou créer une entrée Analytics pour la ressource
        $analytics = $analyticsRepository->findOneBy(['user' => $user]);

        if (!$analytics) {
            $analytics = new Analytics();
            $analytics->setUser($user)
                    ->setViewCount(1)
                    ->setLastViewedAt(new \DateTimeImmutable());
        } else {
            $analytics->setViewCount($analytics->getViewCount() + 1)
                    ->setLastViewedAt(new \DateTimeImmutable());
        }

        $entityManager->persist($analytics);
        $entityManager->flush();

        return new JsonResponse(['success' => true]);
    }

    #[Route('/analytics/top', name: 'analytics_top', methods: ['GET'])]
    public function getTopAnalytics(AnalyticsRepository $analyticsRepository): Response
    {
        // Appel des méthodes du repository
        $topUsers = $analyticsRepository->findTopUsers();
        $topJobPosts = $analyticsRepository->findTopJobPosts();

        // Rendre la vue Twig avec les données
        return $this->render('analytics/top.html.twig', [
            'topUsers' => $topUsers,
            'topJobPosts' => $topJobPosts,
        ]);
    }
}
