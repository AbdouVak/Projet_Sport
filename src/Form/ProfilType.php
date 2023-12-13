<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Regex;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        
        ->add('pseudo', TextType::class, [
            'label' => false,
            'attr' => [
                'placeholder' => 'Pseudo',
                'class' => 'field-register', // Ajouter la classe ici
            ],
            'constraints' => [
                new Length([
                    'min' => 6,
                    'minMessage' => 'Le pseudo doit avoir au moins {{ limit }} caractères.',
                ]),
            ],
        ])
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Email',
                    'class' => 'field-register', // Ajouter la classe ici
                ]
            ])
            ->add('currentPassword', PasswordType::class, [
                'mapped' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Mot de passe',
                    'class' => 'field-register', // Ajouter la classe ici
                ],
                'required' => true,
                'error_bubbling' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez un mot de passe.',
                    ]),
                    new Length([
                        'min' => 10,
                        'minMessage' => 'Votre mot de passe est trop court ! Il doit avoir au moins 10 caractères.',
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{10,}$/',
                        'message' => 'Votre mot de passe doit contenir au moins une majuscule, un caractère spécial et un chiffre.',
                    ]),
                ],
            ])
            
            ->add('submit',SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
