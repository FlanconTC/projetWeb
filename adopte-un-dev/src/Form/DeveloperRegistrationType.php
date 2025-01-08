<?php

namespace App\Form;

use App\Entity\DeveloperProfile;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeveloperRegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label_html' => true,
                'label' => '<i class="fas fa-user"></i> <strong>Nom d\'utilisateur</strong>',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('email', TextType::class, [
                'label_html' => true,
                'label' => '<i class="fas fa-envelope"></i> <strong>Email :</strong>',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'label_html' => true,
                'label' => '<i class="fas fa-lock"></i> <strong>Mot de passe</strong>',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('developerProfile', DeveloperProfileType::class, [
                'label' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
