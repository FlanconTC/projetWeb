<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Favorites;
use App\Entity\DeveloperProfile;
use App\Form\CompanyProfileType;
use App\Form\UserEditType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Response;
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

    #[Route('/profile/edit/dev', name: 'profile_edit_dev')]
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

    #[Route('/profile/edit/company', name: 'profile_edit_company')]
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
    #[Route('/profile/favoris', name: 'profile_favoris')]
    public function favoris(EntityManagerInterface $entityManager): Response
    {
        $id = $this->getUser()->getId();

        $favorites = $entityManager->getRepository(Favorites::class)->findByUserId($id);
        return $this->render('profile/favoris.html.twig', [
            'favorites' => $favorites, 
        ]);
    }
    #[Route('/profile/favoris/add/{id}', name: 'profile_favoris_add')]
    public function favoris_add(EntityManagerInterface $entityManager, $id = 0): Response
    {
        
        $favorites = $entityManager->getRepository(Favorites::class)->findUserExceptId($this->getUser()->getId());
        if($id != 0){
            $favoris = new Favorites();
            $favoris->setUser($this->getUser());
            $favoris->setFavoriteDeveloper(($entityManager->getRepository(DeveloperProfile::class)->findOneByUserId($id)));
            $entityManager->persist($favoris);
            $entityManager->flush();
        }
        return $this->render('profile/favoris_add.html.twig', [
            'favorites' => $favorites, 
        ]);
    }
}
