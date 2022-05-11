<?php

namespace App\Form;

use App\Entity\Exercice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ExerciceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('typeexercice', ChoiceType::class, [
                'choices'  => [
                    'Musculation' => 'Musculation',
                    'Crossfit' => 'Crossfit',
                    'Cardio' => 'Cardio',
                ],
            ])
            ->add('nomexercice')
            ->add('muscle', ChoiceType::class, [
                'choices'  => [
                    'Chest' => 'Chest',
                    'Legs' => 'Legs',
                    'Arms' => 'Arms',
                ],
            ])
            ->add('video')
            ->add('descrexercice')
            ->add('diffexercice', ChoiceType::class, [
                'choices'  => [
                    'Hard' => 'Hard',
                    'Meduim' => 'Meduim',
                    'Easy' => 'Easy',
                ],
            ])
            ->add('justesalleexercice', ChoiceType::class, [
                'choices'  => [
                    'YES' => 'YES',
                    'NO' => 'NO'
                ],
            ])
            ->add('dureeexercice')
            ->add('image', FileType::class, [
                'data_class' => null,
                'mapped' => false,
                'required' => false,

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Exercice::class,
        ]);
    }
}
