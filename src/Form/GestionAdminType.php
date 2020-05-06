<?php

namespace App\Form;

use App\Entity\Participant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GestionAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('motDePasse')
            ->add('prenom')
            ->add('pseudo')
            ->add('telephone')
            ->add('mail')
            ->add('role')
            ->add('image')
            ->add('updatedAt')
            ->add('passwordRequestedAt')
            ->add('token')
            ->add('inscrits')
            ->add('site')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
