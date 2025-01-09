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
    #[Route('/analytics/view/{id}', name: 'analytics_view', methods: ['POST'])]
    public function registerView(int $id, EntityManagerInterface $entityManager, UserRepository $userRepository, JobPostRepository $jobPostRepository, AnalyticsRepository $analyticsRepository): JsonResponse
    {
        $resource = null;
        $type = null;

        // Essayer de trouver d'abord un utilisateur
        $resource = $userRepository->find($id);
        if ($resource) {
            $type = 'user';
        } else {
            // Si ce n'est pas un utilisateur, chercher une fiche de poste
            $resource = $jobPostRepository->find($id);
            if ($resource) {
                $type = 'job_post';
            }
        }

        if (!$resource) {
            return new JsonResponse(['error' => 'Ressource introuvable'], Response::HTTP_NOT_FOUND);
        }

        // Rechercher ou créer une entrée Analytics pour la ressource
        $criteria = $type === 'user' ? ['user' => $resource] : ['jobPost' => $resource];
        $analytics = $analyticsRepository->findOneBy($criteria);

        if (!$analytics) {
            $analytics = new Analytics();
            if ($type === 'user') {
                $analytics->setUser($resource);
            } elseif ($type === 'job_post') {
                $analytics->setJobPost($resource);
            }
            $analytics->setViewCount(1)
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
