<?php
namespace App\Form;

use App\Entity\DeveloperProfile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeveloperProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('location', TextType::class, [
                'label' => 'Localisation',
                'required' => false,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('programmingLanguages', ChoiceType::class, [
                'label' => 'Langages de programmation',
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
                    'id' => 'developerProfile_programmingLanguages',
                    'class' => 'form-select'
                ],
            ])
            // ->add('experienceLevel', ChoiceType::class, [
            //     'label' => 'Niveau d\'expérience',
            //     'choices' => [
            //         '0 - Débutant' => 0,
            //         '1' => 1,
            //         '2' => 2,
            //         '3' => 3,
            //         '4' => 4,
            //         '5 - Expert' => 5,
            //     ],
            //     'required' => true,
            //     'attr' => ['class' => 'form-select'],
            // ])
            ->add('minimunSalary', IntegerType::class, [
                'label' => 'Salaire minimum souhaité',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'min' => 0,
                    'max' => 100000,
                ],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le salaire minimum est requis.']),
                    new Assert\Type(['type' => 'integer', 'message' => 'Le salaire minimum doit être un nombre entier.']),
                    new Assert\Range([
                        'min' => 0,
                        'max' => 100000,
                        'notInRangeMessage' => 'Le salaire minimum doit être compris entre {{ min }} et {{ max }} euros.',
                    ]),
                ],
            ])
            ->add('biography', TextareaType::class, [
                'label' => 'Biographie',
                'required' => false,
                'attr' => ['class' => 'form-control', 'rows' => 5],
            ])
            ->add('avatar', FileType::class, [
                'label' => 'Avatar (image)',
                'required' => false,
                'mapped' => false, // Ne lie pas directement à l'entité (doit être géré manuellement)
                'attr' => ['class' => 'form-control-file'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DeveloperProfile::class,
        ]);
    }
}
