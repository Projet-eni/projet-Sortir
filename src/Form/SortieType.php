<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Sortie;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, ['label' => 'Nom de la sortie : '])
            ->add('dateHeureDebut', DateTimeType::class, [
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                    'hour' => 'Heure', 'minute' => 'Minute', 'second' => 'Second',
                    'label' => 'Date et heure de la sortie : '
                ]
            ])
            ->add('dateLimiteInscription', DateTimeType::class, ['label' => 'Date limite d\'inscription : '])
            ->add('nbInscriptionsMax', IntegerType::class, ['label' => 'Nombre de places : '])
            ->add('duree', IntegerType::class, ['label' => 'Durée : '])
            ->add('infosSortie', TextType::class, ['label' => 'Description et infos : '])
            ->add('lieu', EntityType::class,[
                'class'=>Lieu::class,
                'query_builder' => function(EntityRepository $er){
                return $er->createQueryBuilder('l')
                    ->orderBy('l.nom', 'ASC');
                },
                'choice_label'=> 'Lieu : '
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
