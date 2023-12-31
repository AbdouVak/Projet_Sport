<?php

namespace App\Form;

use App\Entity\CategorieMuscle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SeanceByMuscleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('categorieMuscle', EntityType::class, [
                'class' => CategorieMuscle::class,
                'choice_label' => 'nom',
                'placeholder' => 'Choisissez un muscle',
                'required' => true,
            ])
            ->add('save', SubmitType::class, ['label' => 'Enregistrer']);
    
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}
