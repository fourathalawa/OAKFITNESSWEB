<?php

namespace App\Form;

use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idcreatorevenement', ChoiceType::class, [
                'choices'  => [
                    '1' => '1',
                    '2' => '2'
                ],
            ])
            ->add('dateevenement',DateType::class,[
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('titreevenement')
            ->add('descrevenement',TextType::class)
            ->add('adresseevenement')
            ->add('typeevenement', ChoiceType::class, [
                'choices'  => [
                    'real-life' => 'real-life',
                    'online' => 'online'
                ],
            ])
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
            'data_class' => Evenement::class
        ]);
    }
}
