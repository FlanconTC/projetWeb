<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Favorites;
use App\Entity\DeveloperProfile;
use App\Entity\JobPost;
use App\Form\CompanyProfileType;
use App\Form\UserEditType;
use App\Repository\DeveloperProfileRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfileController extends AbstractController
{

    #[Route('/profile/view', name: 'profile_view')]
    public function view(): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        return $this->render('profile/view.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('dev/profile/edit/dev', name: 'profile_edit_dev')]
    public function editDev(Request $request, EntityManagerInterface $entityManager, FileUploader $fileUploader, UserPasswordHasherInterface $passwordHasher): Response
    {
        // Récupère l'utilisateur connecté
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        // Crée le formulaire pour l'utilisateur
        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarde les modifications
            $plainPassword = $form->get('plainPassword')->getData();
            if ($plainPassword) {
                $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
                $user->setPassword($hashedPassword);
            }

            $avatarFile = $form->get('developerProfile')->get('avatar')->getData();

            if ($avatarFile) {

                $oldAvatar = $user->getDeveloperProfile()->getAvatar();
                if ($oldAvatar) {
                    $oldAvatarPath = $this->getParameter('kernel.project_dir') . '/public/avatars/' . $oldAvatar;
                    if (file_exists($oldAvatarPath)) {
                        unlink($oldAvatarPath);
                    }
                }

                $avatarFilename = $fileUploader->upload($avatarFile);
                // Mettez à jour l'entité DeveloperProfile avec le nouveau nom de fichier
                $user->getDeveloperProfile()->setAvatar($avatarFilename);
            }

            $entityManager->flush();

            $this->addFlash('success', 'Vos informations ont été mises à jour avec succès.');

            return $this->redirectToRoute('profile_edit_dev');
        }

        return $this->render('profile/edit_dev.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('company/profile/edit/company', name: 'profile_edit_company')]
    public function editComapny(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour modifier votre profil.');
        }

        $form = $this->createForm(CompanyProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();
            if ($plainPassword) {
                $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
                $user->setPassword($hashedPassword);
            }
            $entityManager->flush();

            $this->addFlash('success', 'Votre profil a été mis à jour avec succès.');

            return $this->redirectToRoute('profile_edit_company');
        }

        return $this->render('profile/edit_company.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/profile/prive', name: 'profile_prive')]
    public function prive(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        $user->setPrive(!$user->getPrive());
        $entityManager->flush();
        return $this->redirectToRoute('profile_view');
    }


    #[Route('/profile/favorites', name: 'profile_favorites')]
    public function showFavorites(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour voir vos favoris.');
        }

        $favorites = $entityManager->getRepository(Favorites::class)->findBy(['user' => $user]);

        return $this->render('profile/favorites.html.twig', [
            'favorites' => $favorites,
        ]);
    }

    #[Route('/favorite/add/dev/{developerId}', name: 'favorite_add_dev', methods: ['POST'])]
    public function addFavoriteDeveloper(int $developerId, EntityManagerInterface $entityManager, DeveloperProfileRepository $developerProfileRepository): JsonResponse {
        $user = $this->getUser();
    
        if (!$user || !$this->isGranted('ROLE_COMPANY')) {
            return $this->json(['error' => 'Accès interdit. Vous n\'avez pas les permissions nécessaires.'], Response::HTTP_FORBIDDEN);
        }

        $developerProfile = $entityManager->getRepository(DeveloperProfile::class)->findByUserIntId($developerId);

        if (!$developerProfile) {
            return $this->json(['error' => 'Développeur introuvable.'], Response::HTTP_NOT_FOUND);
        }
    
        $existingFavorite = $entityManager->getRepository(Favorites::class)
            ->findOneBy(['user' => $user, 'favoriteDeveloper' => $developerProfile]);
    
        if ($existingFavorite) {
            return $this->json(['error' => 'Ce développeur est déjà en favoris.'], Response::HTTP_CONFLICT);
        }
    
        $favorite = new Favorites();
        $favorite->setUser($user);
        $favorite->setFavoriteDeveloper($developerProfile);
    
        $entityManager->persist($favorite);
        $entityManager->flush();
    
        return $this->json(['success' => 'Développeur ajouté aux favoris.'], Response::HTTP_CREATED);
    }
    
    #[Route('/favorite/add/job/{jobPostId}', name: 'favorite_add_job', methods: ['POST'])]
    public function addFavoriteJob(int $jobPostId, EntityManagerInterface $entityManager): JsonResponse {
        $user = $this->getUser();
    
        if (!$user || !$this->isGranted('ROLE_DEV')) {
            return $this->json(['error' => 'Accès interdit. Vous n\'avez pas les permissions nécessaires.'], Response::HTTP_FORBIDDEN);
        }
    
        $jobPost = $entityManager->getRepository(JobPost::class)->find($jobPostId);
    
        if (!$jobPost) {
            return $this->json(['error' => 'Fiche de poste introuvable.'], Response::HTTP_NOT_FOUND);
        }
    
        $existingFavorite = $entityManager->getRepository(Favorites::class)
            ->findOneBy(['user' => $user, 'favoriteJob' => $jobPost]);
    
        if ($existingFavorite) {
            return $this->json(['error' => 'Cette fiche de poste est déjà en favoris.'], Response::HTTP_CONFLICT);
        }
    
        $favorite = new Favorites();
        $favorite->setUser($user);
        $favorite->setFavoriteJob($jobPost);
    
        $entityManager->persist($favorite);
        $entityManager->flush();
    
        return $this->json(['success' => 'Fiche de poste ajoutée aux favoris.'], Response::HTTP_CREATED);
    }
    
    #[Route('/favorite/remove/{type}/{id}', name: 'favorite_remove', methods: ['DELETE'])]
    public function removeFavorite(string $type, int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $this->getUser();
    
        if (!$user) {
            return $this->json(['error' => 'Accès interdit.'], Response::HTTP_FORBIDDEN);
        }
    
        // Récupérer le favori par ID
        $favorite = $entityManager->getRepository(Favorites::class)->find($id);
    
        if (!$favorite || $favorite->getUser() !== $user) {
            return $this->json(['error' => 'Favori introuvable.'], Response::HTTP_NOT_FOUND);
        }
    
        // Vérifier le type et supprimer en conséquence
        if ($type === 'developer' && $favorite->getFavoriteDeveloper() !== null && $this->isGranted('ROLE_COMPANY')) {
            $entityManager->remove($favorite);
        } elseif ($type === 'job' && $favorite->getFavoriteJob() !== null && $this->isGranted('ROLE_DEV')) {
            $entityManager->remove($favorite);
        } else {
            return $this->json(['error' => 'Type invalide ou accès non autorisé.'], Response::HTTP_FORBIDDEN);
        }
    
        // Supprimer et sauvegarder
        $entityManager->flush();
    
        return $this->json(['success' => 'Favori supprimé.'], Response::HTTP_OK);
    }
    
}
