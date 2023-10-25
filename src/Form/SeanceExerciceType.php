<?php

namespace App\Form;

use App\Entity\SeanceExercice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SeanceExerciceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('serie')
            ->add('repetition')
            ->add('poid')
            ->add('exercice')
            ->add('seance')
            ->add('submit',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SeanceExercice::class,
        ]);
    }
}
