<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Repository\UserRepository;
use App\Repository\EvaluationRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\MatchingRepository;
use App\Repository\JobPostRepository;
use App\Repository\DeveloperProfileRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\SecurityBundle\Security;
use App\Entity\Matching;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home_page')]
    public function index(Security $security, JobPostRepository $jobPostRepository): Response
    {
        if (!$security->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        $userCurrent = $security->getUser();
        $roles = $userCurrent->getRoles();
        $arrayJob = [];
        if (in_array('ROLE_COMPANY', $roles)) {
            $arrayJob = $jobPostRepository->findByCompany($userCurrent);
        }
        return $this->render('home_page/index.html.twig', [
            'controller_name' => 'HomePageController',
            'arrayJob' => $arrayJob
        ]);
    }

    #[Route('/date/{typeRecherche}', name: 'app_home_getusers')]
    public function recupUsers(MatchingRepository $matchingRepository, $typeRecherche, Security $security, EvaluationRepository $evaluationRepository, JobPostRepository $jobPostRepository, UserRepository $userRepository, NormalizerInterface $normalizer, DeveloperProfileRepository $developerProfileRepository): JsonResponse
    {
        if (!$security->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $listeDevPourSwipe = [];
        $userC = $security->getUser();
        $roles = $userC->getRoles();
        $ftl = 'comp';
        if (in_array('ROLE_DEV', $roles)) {
            $ftl = "dev";
        }
        if ($typeRecherche == 'company') {
            $fiches = $jobPostRepository->findOneByAll();
            if ($ftl == "dev") {
                $dejaLike = $matchingRepository->findById($developerProfileRepository->findOneByUser($userC));

                foreach ($dejaLike as $poste) {

                    foreach ($fiches as $key => $fiche) {
                        if ($fiche->getId() == $poste->getJobPost()->getId()) {
                            unset($fiches[$key]);
                        }
                    }
                }
            }
            foreach ($fiches as $fiche) {
                if ($fiche != null) {
                    $jsonBody = [
                        'ftl' => $ftl,
                        'idD' => $userC->getId(),
                        'id' => $fiche->getId(),
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
        } else {
            $users = $userRepository->findUsersDev();
            $usersTrimmed = $users;
            foreach ($users as $key => $user) {
                if (in_array('ROLE_COMPANY', $user['roles'])) { //FAIRE UN DEUXIEME TRIM
                    unset($usersTrimmed[$key]);
                }
            }

            if ($ftl == 'comp') {
                $ficheDePoste = $jobPostRepository->findByCompany($userC);

                foreach ($usersTrimmed as $key => $user) {
                    foreach ($ficheDePoste as $cle => $fiche) {

                        $dejaLike = $matchingRepository->findByIdE($fiche);
                        
                        if ($dejaLike != []) {
                            foreach ($dejaLike as $keyL => $like) {
                                if ($usersTrimmed[$key] != null && $like->getDeveloper() ==$usersTrimmed[$key] ) {
                                    unset($usersTrimmed[$key]);
                                }
                            }
                        }
                    }
                }
            }

            foreach ($usersTrimmed as $user) {
                $dev = $developerProfileRepository->findOneByUser($userRepository->findOneById($user['id']));
                if ($dev != null) {
                    $dataNote = $evaluationRepository->findOneByUser($user['id']);
                    $note = $dataNote[0]['sum'] / $dataNote[0]['count'];

                    $jsonBody = [
                        'ftl' => $ftl,
                        'id' => $user['id'],
                        'id_utilisateur' => $user['id'],
                        'nom' => $user['username'],
                        'bio' => $dev->getBiography(),
                        'icon' => $dev->getAvatar(),
                        'note' => $note,
                        'prog' => $dev->getProgrammingLanguages(),
                        'exp' => $dev->getExperienceLevel(),
                    ];
                    $thisUser = $userRepository->findOneById($user['id']);
                    if (!$thisUser->getPrive()) {
                        $jsonBody['email'] = $user['email'];
                        $jsonBody['minS'] = $dev->getMinimunSalary();
                        $jsonBody['location'] = $dev->getLocation();
                    }

                    array_push($listeDevPourSwipe, $jsonBody);
                }
            }
        }

        return new JsonResponse(['users' => $listeDevPourSwipe]);
    }

    #[Route('/like/{id}', name: 'app_home_like')]
    #[Route('/like/{id}/{idJob}', name: 'app_home_likeJ')]
    public function like($id,  Security $security, UserRepository $userRepository, MatchingRepository $matchingRepository, EntityManagerInterface $entityManager, JobPostRepository $jobPostRepository, DeveloperProfileRepository $developerProfileRepository, $idJob = null): JsonResponse
    {
        $userCurrent = $security->getUser();
        $roles = $userCurrent->getRoles();
        $match = new Matching();

        if (in_array('ROLE_DEV', $roles)) {
            $jobPost = $jobPostRepository->findOneById($id);
            $dev = $developerProfileRepository->findOneByUser($userCurrent);
            $ftl = 'dev';
        } else {

            $fichesDePoste = $jobPostRepository->findByCompany($userCurrent);

            if (empty($fichesDePoste)) {
                return new JsonResponse([
                    'error' => 'Vous devez créer une fiche de poste avant de pouvoir liker.',
                    'redirect' => '/company/job-post/new', // Route pour créer une fiche de poste
                ], 400);
            }

            $jobPost = $jobPostRepository->findOneById($id);
            $dev =  $developerProfileRepository->findOneByUser($userRepository->findOneById($idJob));
            $ftl = 'ent';
        }

        $match = $matchingRepository->findOneByCouple($dev, $jobPost);
        if ($match == null) {
            $match = new Matching();
            $match->setDeveloper($dev);
            $match->setJobPost($jobPost);
            $match->setMatchScore(1);
            $match->setFirstToLike($ftl);
            $entityManager->persist($match);
            $entityManager->flush();
        } else if ($ftl != $match->getFirstToLike()) {
            $match->setMatchScore(2);   //ROUTE CREER UNE MESSAGERIE
            $entityManager->flush();
        }
        return new JsonResponse(['users' => 'ok']);
    }

    #[Route('/api/user/role', name: 'user_role')]
    public function getRoles(Security $security): JsonResponse
    {
        $userCurrent = $security->getUser();
        $roles = $userCurrent->getRoles();
        $roleLib = ["role" => 'userComp'];
        if (in_array('ROLE_DEV', $roles)) {
            $roleLib = ["role" => 'userDev'];
        }
        return new JsonResponse(['roles' => $roleLib]);
    }
}
