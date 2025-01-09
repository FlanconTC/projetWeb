<?php

namespace App\Controller;

use App\Repository\DeveloperProfileRepository;
use App\Repository\AnalyticsRepository;
use App\Repository\JobPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DynamiquePageController extends AbstractController
{
    #[Route('/company', name: 'app_company')]
    public function indexEntreprise(DeveloperProfileRepository $developerProfileRepo, AnalyticsRepository $analyticsRepo): Response
    {
        // Les développeurs les plus consultés
        $mostViewedDevelopers = $analyticsRepo->findTopUsers(3);

        // Les 3 derniers profils créés
        $latestDevelopers = $developerProfileRepo->findLatestDevelopers();

        return $this->render('accueil/company.html.twig', [
            'mostViewedDevelopers' => $mostViewedDevelopers,
            'latestDevelopers' => $latestDevelopers,
        ]);
    }

    #[Route('/dev', name: 'app_dev')]
    public function indexDeveloppeur(JobPostRepository $jobPostRepo): Response
    {
        // Les postes les plus populaires
        $popularPosts = $jobPostRepo->findPopularPosts();

        // Les 3 dernières offres publiées
        $latestPosts = $jobPostRepo->findLatestPosts();

        return $this->render('accueil/dev.html.twig', [
            'popularPosts' => $popularPosts,
            'latestPosts' => $latestPosts,
        ]);
    }
}
