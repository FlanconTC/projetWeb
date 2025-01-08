<?php
namespace App\Form;

use App\Entity\User;
use App\Entity\DeveloperProfile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label_html' => true,
                'label' => '<i class="fas fa-user"></i> <strong>Nom d\'utilisateur</strong>',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('email', EmailType::class, [
                'label_html' => true,
                'label' => '<i class="fas fa-envelope"></i> <strong>Email :</strong>',
                'attr' => ['class' => 'form-control'],
            ]);

        // Ajouter les champs spécifiques au profil développeur si c'est un développeur
        if ($options['data']->getDeveloperProfile()) {
            $builder
                ->add('developerProfile', DeveloperProfileType::class, [
                    'label' => false,
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
