<?php

namespace App\Form;

use App\Data\FiltreRechecheSortie;
use App\Entity\Site;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiltreFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('site',EntityType::class,['label'=>'site :',
                                                        'class'=>Site::class,
                                                        'query_builder'=>function(EntityRepository $er)
                                                         {
                                                         return $er->createQueryBuilder('c');
                                                         },'choice_label'=>'site'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FiltreRechecheSortie::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
