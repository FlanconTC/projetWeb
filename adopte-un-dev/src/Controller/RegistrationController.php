<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\DeveloperProfile;
use App\Form\DeveloperRegistrationType;
use App\Form\CompanyRegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FileUploader;

class RegistrationController extends AbstractController
{
    #[Route('/register/developer', name: 'register_developer')]
    public function registerDeveloper(Request $request, FileUploader $fileUploader, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $user->setRoles(['ROLE_DEV']);
        $profile = new DeveloperProfile();
        $user->setDeveloperProfile($profile);
    
        $form = $this->createForm(DeveloperRegistrationType::class, $user);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Hachage du mot de passe
            $hashedPassword = $passwordHasher->hashPassword($user, $form->get('plainPassword')->getData());
            $user->setPassword($hashedPassword);
        
            // Gestion de l'avatar avec le Service FileUploader
            $avatarFile = $form->get('developerProfile')->get('avatar')->getData();
            if ($avatarFile) {
                $avatarFileName = $fileUploader->upload($avatarFile);
                $user->getDeveloperProfile()->setAvatar($avatarFileName);
            }
        
            $entityManager->persist($user);
            $entityManager->flush();
        
            return $this->redirectToRoute('app_login');
        }
    
        return $this->render('registration/register_developer.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    

    #[Route('/register/company', name: 'register_company')]
    public function registerCompany(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $user->setRoles(['ROLE_COMPANY']);

        $form = $this->createForm(CompanyRegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hashedPassword = $passwordHasher->hashPassword($user, $form->get('plainPassword')->getData());
            $user->setPassword($hashedPassword);

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register_company.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
