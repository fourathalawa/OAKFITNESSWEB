<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomproduit')
            ->add('categproduit', ChoiceType::class, [
                'choices'  => [
                    'Whey' => 'Whey',
                    'Mass Gainer' => 'Mass Gainer',
                    'Amino Acids' => 'Amino Acids',
                    'Vitamines' => 'Vitamines',
                    'Creatine' => 'Creatine',
                    'Capsules' => 'capsules',
                    'Others' => 'Others',
                ],
            ])
            ->add('descrproduit',TextareaType::class)
            ->add('prixproduit')
            ->add('isavailable',ChoiceType::class,[
            'choices'=>[
                'yes' => '1',
                'no' => '0',
            ],
                'expanded' => true
                ])
            ->add('imageproduit',FileType::class ,array('data_class' => null ,'required' => false))
            ->add('stockproduit')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
