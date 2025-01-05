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
            ])
            ->add('location', TextType::class, [
                'label' => 'Localisation',
                'required' => false,
            ])
            ->add('requiredTechnologies', ChoiceType::class, [
                'label' => 'Technologies recherchées',
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
                    'class' => 'form-select'
                ],
            ])
            ->add('requiredExperience', IntegerType::class, [
                'label' => 'Niveau d\'expérience requis (en années)',
                'required' => false,
            ])
            ->add('offeredSalary', IntegerType::class, [
                'label' => 'Salaire proposé',
                'required' => false,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description détaillée',
                'required' => false,
            ])
            ->add('company', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'username', // ou 'email' si vous préférez
                'label' => 'Entreprise',
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
