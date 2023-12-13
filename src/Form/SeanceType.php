<?php

namespace App\Form;

use App\Entity\Exercice;
use App\Entity\Seance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class SeanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom',TextType::class,[
            'constraints' => [
                new NotBlank([
                    'message' => 'Le champ nom ne peut pas être vide.',
                ]),
                new Length([
                    'min' => 2,
                    'max' => 255,
                    'minMessage' => 'Le nom doit avoir au moins {{ limit }} caractères.',
                    'maxMessage' => 'Le nom ne peut pas dépasser {{ limit }} caractères.',
                ]),
            ],
        ])
        ->add('exercice', EntityType::class, [
            'class' => Exercice::class,
            'choice_label' => 'nom',
            'placeholder' => 'Choisissez un exercice',
            'required' => true,
        ])
        ->add('serie', null, [
            'label' => 'Série',
            'attr' => ['placeholder' => 'Entrez le nombre de séries']
        ])
        ->add('repetition', null, [
            'label' => 'Répétition',
            'attr' => ['placeholder' => 'Entrez le nombre de répétitions']
        ])
        ->add('poid', null, [
            'label' => 'Poids',
            'attr' => ['placeholder' => 'Entrez le poids']
        ])
        ->add('csrf_token', HiddenType::class, [
            'mapped' => false,
        ])
        ->add('submit',SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
