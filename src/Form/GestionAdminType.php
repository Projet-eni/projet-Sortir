<?php

namespace App\Form;

use App\Entity\Participant;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GestionAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('participant', EntityType::class,[
                'class'=>Participant::class,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.nom', 'ASC');
                },
                'choice_label'=> 'nom'.'prenom'.'actif',
                'label' => 'Utilisateur : ',
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
