<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\CompanyProfileType;
use App\Form\UserEditType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function editDev(Request $request, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
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
    public function editComapny(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour modifier votre profil.');
        }

        $form = $this->createForm(CompanyProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Votre profil a été mis à jour avec succès.');

            return $this->redirectToRoute('profile_edit_company');
        }

        return $this->render('profile/edit_company.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
