<?php

namespace App\Form;

use App\Entity\Entreprise;
use App\Entity\FicheDePoste;
use App\Entity\Historique;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class EntType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class, [
            'label' => 'Nom',
            'required' => true, // Non nul
            'constraints' => [
                new Assert\NotBlank([
                    'message' => 'Le nom ne peut pas être vide.',
                ]),
            ],
        ])
        ->add('role', TextType::class, [
            'label' => 'Role',
            'required' => false,
            'label' => false,
            'attr' => ['style' => 'display:none;'],
            'data' => 'ROLE_USER',
        ])
        ->add('profile', TextType::class, [
            'label' => 'Profile',
            'required' => false,
            'label' => false,
            'attr' => ['style' => 'display:none;'],
            'data' => 'Ent',
        ])
        ->add('localisation', TextType::class, [
            'label' => 'Localisation',
            'required' => true, // Non nul
            'constraints' => [
                new Assert\NotBlank([
                    'message' => 'La localisation ne peut pas être vide.',
                ]),
            ],
        ])
        ->add('password', TextType::class, [
            'label' => 'Password',
            'required' => true, // Non nul
            'constraints' => [
                new Assert\NotBlank([
                    'message' => 'Le mot de passe ne peut pas être vide.',
                ]),
            ],
        ])
        ->add('historique', EntityType::class, [
            'class' => Historique::class,
            'choice_label' => 'id',
            'required' => false,
            'label' => false,
            'attr' => ['style' => 'display:none;'],
            'empty_data' => null,
        ])
            ->add('ficheDePoste', EntityType::class, [
                'class' => FicheDePoste::class,
                'choice_label' => 'id',
                'required' => false,
                'label' => false,
                'attr' => ['style' => 'display:none;'],
                'empty_data' => null,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }
}
