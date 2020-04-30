<?php

namespace App\Form;

use App\Entity\Filtre;
use App\Entity\Site;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiltreType extends AbstractType
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
            ->add('search',TextType::class,['label'=>'Le nom de la sortie contient ',
                                                            'required'=>false])
            ->add('dateDebut',DateType::class,['label'=>'Entre ',
                                    'input'=>'datetime_immutable'])
            ->add('dateFin',DateType::class,['label'=>' et ',
                                    'input'=>'datetime_immutable'])
            ->add('checkboxOrganisateur', CheckboxType::class,['label'=>'Sorties dont je suis l\' organisateur/trice',
                                                                            'required'=>false])
            ->add('checkboxInscrit', CheckboxType::class,['label'=>'Sorties auxquelles je suis inscrit/e',
                                                                            'required'=>false])
            ->add('checkboxNonInscrit', CheckboxType::class,['label'=>'Sorties auxquelles je ne suis pas inscrit/e',
                                                                            'required'=>false])
            ->add('checkboxSortiesPassees', CheckboxType::class,['label'=>'Sorties passées',
                                                                            'required'=>false])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Filtre::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}