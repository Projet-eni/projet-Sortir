<?php

namespace App\Form;

use App\Data\FiltreRechecheSortie;
use App\Entity\Site;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiltreRecherche extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fSite',EntityType::class,['label'=>'Site :',
                'class'=>Site::class,
                'query_builder'=>function(EntityRepository $er)
                {
                    return $er->createQueryBuilder('c');
                },'choice_label'=>'nom'])
            ->add('search',SearchType::class,['label'=>'Le nom de la sortie contient '])
            ->add('dateDebut',DateType::class,['label'=>'Entre '])
           // ->add('checkboxOrganisateur', CheckboxType::class,['label'=>'Sorties dont je suis l\' organisateur/trice'])
           // ->add('checkboxInscrit', CheckboxType::class,['label'=>'Sorties auxquelles je suis inscrit/e'])
           // ->add('checkboxOrganisateur', CheckboxType::class,['label'=>'Sorties dont je suis l\' organisateur/trice'])
           // ->add('checkboxOrganisateur', CheckboxType::class,['label'=>'Sorties dont je suis l\' organisateur/trice'])


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