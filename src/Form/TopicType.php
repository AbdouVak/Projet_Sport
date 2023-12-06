<?php

namespace App\Form;

use App\Entity\Topic;
use App\Form\CategorieMuscleType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TopicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class,[
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne peut pas être vide.',
                    ]),
                    new Length([
                        'min' => 4,
                        'minMessage' => 'La valeur doit contenir au moins {{ limit }} caractères.',
                    ]),
                ]])
                

            ->add('categorieTopic', EntityType::class, [
                'class' => 'App\Entity\CategorieTopic',
                'attr' => ['id' => 'addTopicTexteArea'],
                'choice_label' => 'categorie', // Le champ qui sera affiché dans la liste déroulante
            ])
            ->add('contenue', TextareaType::class)
            ->add('csrf_token', HiddenType::class, [
                'mapped' => false,
            ])
            ->add('submit', SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Topic::class,
        ]);
    }
}
