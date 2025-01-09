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
                'label_html' => true,
                'label' => '<i class="fas fa-map-marker-alt"></i> <strong>Localisation :</strong>',
                'required' => false,
                'attr' => ['class' => 'form-control mb-3'],
            ])
            ->add('programmingLanguages', ChoiceType::class, [
                'label_html' => true,
                'label' => '<i class="fas fa-code"></i> <strong>Langages de programmation :</strong>',
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
                    'class' => 'form-select mb-3'
                ],
            ])
            ->add('minimunSalary', IntegerType::class, [
                'label_html' => true,
                'label' => '<i class="fas fa-euro-sign"></i> <strong>Salaire minimum :</strong>',
                'required' => true,
                'attr' => [
                    'class' => 'form-control mb-3',
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
                'label_html' => true,
                'label' => '<i class="fas fa-info-circle"></i> <strong>Biographie :</strong>',
                'required' => false,
                'attr' => ['class' => 'form-control mb-3', 'rows' => 5],
            ])
            ->add('avatar', FileType::class, [
                'label_html' => true,
                'label' => '<i class="fas fa-user-circle"></i> <strong>Avatar(Image) :</strong>',
                'required' => false,
                'mapped' => false, // Ne lie pas directement à l'entité (doit être géré manuellement)
                'attr' => ['class' => 'form-control-file form-control mb-3'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DeveloperProfile::class,
        ]);
    }
}
