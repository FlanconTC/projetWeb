<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Repository\UserRepository;
use App\Repository\EvaluationRepository;
use App\Repository\JobPostRepository;
use App\Repository\DeveloperProfileRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\SecurityBundle\Security;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home_page')]
    public function index(Security $security): Response
    {
        // Vérifier si l'utilisateur est authentifié
        if (!$security->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('home_page/index.html.twig', [
            'controller_name' => 'HomePageController',
        ]);
    }


    #[Route('/date/{typeRecherche}', name: 'app_home_getusers')]
    public function recupUsers($typeRecherche, Security $security, EvaluationRepository $evaluationRepository, JobPostRepository $jobPostRepository, UserRepository $userRepository, NormalizerInterface $normalizer, DeveloperProfileRepository $developerProfileRepository): JsonResponse
    {
        if (!$security->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        $listeDevPourSwipe = [];
        $userC = $security->getUser();
        $roles = $userC->getRoles();
        if ($typeRecherche == 'company') 
        {
            $fiches = $jobPostRepository->findOneByAll();
            foreach ($fiches as $fiche) {
                if($fiche != null)
                $jsonBody = [
                    'id' => $fiche->getCompany()->getId(),
                    'nomE' => $fiche->getCompany()->getUsername(),
                    'nom' => $fiche->getTitle(),
                    'email' => $fiche->getCompany()->getEmail(),
                    'location' => $fiche->getLocation(),
                    'prog' => $fiche->getRequiredTechnologies(),
                    'exp' => $fiche->getRequiredExperience(),
                    'minS' => $fiche->getOfferedSalary(),
                    'bio' => $fiche->getDescription(),
                    'note' => 10
                ];
                array_push($listeDevPourSwipe, $jsonBody);
            }
        } 
        else 
        {
            $users = $userRepository->findUsersDev();
            $usersTrimmed = $users;
            foreach ($users as $key => $user) {
                if (in_array('ROLE_COMPANY', $user['roles'])) {
                    unset($usersTrimmed[$key]);
                }
            }


            foreach ($usersTrimmed as $user) {
                
                $dev = $developerProfileRepository->findOneByUser($userRepository->findOneById($user['id']));
                
                if ($dev != null)
                $dataNote = $evaluationRepository->findOneByUser($user['id']);
                $note = $dataNote[0]['sum']/$dataNote[0]['count'];
                    $jsonBody = [
                        'id_utilisateur' => $user['id'],
                        'nom' => $user['username'],
                        'email' => $user['email'],
                        'location' => $dev->getLocation(),
                        'prog' => $dev->getProgrammingLanguages(),
                        'exp' => $dev->getExperienceLevel(),
                        'minS' => $dev->getMinimunSalary(),
                        'bio' => $dev->getBiography(),
                        'icon' => $dev->getAvatar(),
                        'note' => $note,
                    ];
                array_push($listeDevPourSwipe, $jsonBody);
            }
        }

        return new JsonResponse(['users' => $listeDevPourSwipe]);
    }
}
