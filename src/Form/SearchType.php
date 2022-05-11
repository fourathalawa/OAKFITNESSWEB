<?php

namespace App\Form;

use App\Data\SearchData;
use App\Entity\Evenement;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function __construct(EntityManagerInterface $em) {
        $this->em = $em; // Pass 'EntityManager' as Service argument.
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $creators = $this->em->getRepository(Evenement::Class)->getCreators();
        $creatorsChoices = [];
        foreach($creators as $k=>$v) {
            $creatorsChoices[$k] = $v['idcreatorevenement'];
        }

        $builder
            ->add('creators',ChoiceType::class, [
                'mapped'=>true,
                'required' => false,
                'multiple' => true,
                'expanded' => true,
                'label'    => "Select form the below",
                'choices' => $creatorsChoices,
            ])
            ->add('minDate',DateType::class, [
                'label'=>false,
                'required'=>false,
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr'=> [
                    'placeholder' =>'lowest date'
                ]
            ])
            ->add('maxDate',DateType::class, [
                'label'=>false,
                'required'=>false,
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr'=> [
                    'placeholder' =>'highest date'
                ]
            ])
            ->add('online', CheckboxType::class, [
                'label'=>'is Online?',
                'required'=>false,
                'attr' => array('checked' => 'checked', 'value' => 'online')
            ])

            ->add('q', TextType::class, [
                'label' => false,
                'required'=>false,
                'attr'=>['
                placeholder' =>'Chercher']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}