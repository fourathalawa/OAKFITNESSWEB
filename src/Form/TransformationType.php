<?php

namespace App\Form;

use App\Entity\Transformation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class TransformationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
             //integration sessions
            ->add('iduser',  HiddenType::class )
            ->add('titreimage')
            ->add('descreptionimage' ,TextareaType::class)
            ->add('imageavant',FileType::class , array('data_class' => null ,'required' => false))
            ->add('imageapres',FileType::class , array('data_class' => null ,'required' => false))
            ->add('poidavant')
            ->add('poidapres')
            ->add('tailleavant',NumberType::class)
            ->add('tailleapres',NumberType::class)
            ->add('tlike',  HiddenType::class ,[
                'required'   => false,
                'empty_data' => '0',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transformation::class,
        ]);
    }
}
