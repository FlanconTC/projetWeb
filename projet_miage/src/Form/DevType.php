<?php

namespace App\Form;

use App\Entity\Dev;
use App\Entity\Entreprise;
use App\Entity\Historique;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class DevType extends AbstractType
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
                'data' => 'Dev',
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
            ->add('langagesDeProg', TextType::class, [
                'label' => 'Langages de Programmation',
                'required' => true, // Non nul
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Les langages de programmation ne peuvent pas être vides.',
                    ]),
                ],
            ])
            ->add('niveauExperience', TextType::class, [
                'label' => 'Niveau d\'expérience',
                'required' => true, // Non nul
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le niveau d\'expérience ne peut pas être vide.',
                    ]),
                ],
            ])
            ->add('salaireMin', NumberType::class, [
                'label' => 'Salaire Minimum',
                'required' => true, // Non nul
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le salaire minimum ne peut pas être vide.',
                    ]),
                    new Assert\Range([
                        'min' => 0,
                        'minMessage' => 'Le salaire minimum doit être supérieur ou égal à 0.',
                    ]),
                ],
            ])
            ->add('biographie', TextareaType::class, [
                'label' => 'Biographie',
                'required' => false, // Peut être vide
            ])
            ->add('avatar', FileType::class, [
                'label' => 'Avatar (Image)',
                'required' => false,
                'mapped' => false,
            ])
            ->add('nbVues', IntegerType::class, [
                'label' => 'Nombre de Vues',
                'required' => true, // Non nul
                'label' => false,
                'attr' => ['style' => 'display:none;'],
                'data' => 0,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le nombre de vues ne peut pas être vide.',
                    ]),
                    new Assert\Type([
                        'type' => 'integer',
                        'message' => 'Le nombre de vues doit être un entier.',
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
            ->add('favorisDev', EntityType::class, [
                'class' => Entreprise::class,
                'choice_label' => 'id',
                'required' => false,
                'label' => false,
                'attr' => ['style' => 'display:none;'],
                'empty_data' => null,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dev::class,
        ]);
    }
}
