<?php

namespace App\Form;

use App\Entity\SeanceExercice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SeanceExerciceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
            ->add('exercice', EntityType::class, [
                'class' => 'App\Entity\Exercice', // ajustez la classe en fonction de votre structure
                'choice_label' => 'nom', // ajustez en fonction de la propriété que vous souhaitez afficher
                'label' => 'Exercice'
            ])
            ->add('seance', EntityType::class, [
                'class' => 'App\Entity\Seance', // ajustez la classe en fonction de votre structure
                'choice_label' => 'nom', // ajustez en fonction de la propriété que vous souhaitez afficher
                'label' => 'Séance'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SeanceExercice::class,
        ]);
    }
}
