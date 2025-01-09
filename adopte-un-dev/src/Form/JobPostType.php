<?php

namespace App\Form;

use App\Entity\JobPost;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobPostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre du poste',
                'attr' => ['class' => 'form-control mb-3'],
            ])
            ->add('location', TextType::class, [
                'label_html' => true,
                'label' => '<i class="fas fa-map-marker-alt"></i> <strong>Localisation :</strong>',
                'required' => false,
                'attr' => ['class' => 'form-control mb-3'],
            ])
            ->add('requiredTechnologies', ChoiceType::class, [
                'label_html' => true,
                'label' => '<i class="fas fa-code"></i> <strong>Technologies recherchées :</strong>',
                'choices' => [
                    'PHP' => 'php',
                    'JavaScript' => 'javascript',
                    'Python' => 'python',
                    'Java' => 'java',
                    'C#' => 'csharp',
                    'C++' => 'cplusplus',
                    'Ruby' => 'ruby',
                    'Go' => 'go',
                    'Rust' => 'rust',
                    'TypeScript' => 'typescript',
                    'Swift' => 'swift',
                    'Kotlin' => 'kotlin',
                ],
                'multiple' => true,
                'expanded' => false,
                'attr' => [
                    'id' => 'job_post_requiredTechnologies',
                    'class' => 'form-select mb-3'
                ],
            ])
            ->add('requiredExperience', ChoiceType::class, [
                'label_html' => true,
                'label' => '<i class="fas fa-user"></i> <strong>Niveau d\'expérience requis :</strong>',
                'choices' => [
                    '0 - Débutant' => 0,
                    '1 - Junior' => 1,
                    '2 - Intermédiaire' => 2,
                    '3 - Confirmé' => 3,
                    '4 - Avancé' => 4,
                    '5 - Expert' => 5,
                ],
                'required' => false,
                'attr' => ['class' => 'form-control mb-3'],
            ])
            ->add('offeredSalary', IntegerType::class, [
                'label_html' => true,
                'label' => '<i class="fas fa-euro-sign"></i> <strong>Salaire proposé :</strong>',
                'required' => false,
                'attr' => ['class' => 'form-control mb-3'],
            ])
            ->add('description', TextareaType::class, [
                'label_html' => true,
                'label' => '<i class="fas fa-info-circle"></i> <strong>Description détaillée :</strong>',
                'required' => false,
                'attr' => ['class' => 'form-control mb-3', 'rows' => 5],
            ])
            ->add('company', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'username', // ou 'email' si vous préférez et faire en sorte de ne pas pouvoir le modifier (hidden)
                'label' => 'Entreprise',
                'attr' => ['class' => 'form-control mb-3'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => JobPost::class,
        ]);
    }
}
