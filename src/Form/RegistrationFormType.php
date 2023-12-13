<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use VictorPrdh\RecaptchaBundle\Form\ReCaptchaType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Email',
                    'class' => 'field-register', // Ajouter la classe ici
                ],
            ])
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
            ->add('agreeTerms', CheckboxType::class, [
                'label_html' => true,
                'required' => true,
                'label' => 'J\'ai lu et accepté les <a href="cgu">Conditions Générales d\'Utilisation</a>',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les CGU.',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'mapped' => false,
                'type' => PasswordType::class,
                'invalid_message' => 'Les champs de mot de passe doivent correspondre.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Mot de passe',
                        'class' => 'field-register', // Ajouter la classe ici
                    ],
                ],
                'second_options' => [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Répéter le mot de passe',
                        'class' => 'field-register', // Ajouter la classe ici
                    ],
                ],
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
        
            ->add("captcha",ReCaptchaType::class, [
                'attr' => [
                    'class' => 'input-register', // Ajouter la classe ici
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer'
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
