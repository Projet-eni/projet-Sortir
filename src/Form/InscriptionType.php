<?php

namespace App\Form;

use App\Entity\Participant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, ['label' => 'Nom : '])
            ->add('prenom', TextType::class, ['label' => 'Prénom : '])
            ->add('pseudo', TextType::class, ['label' => 'Pseudo : ',
                'attr'=> ['title'=>'Le pseudo doit contenir une majuscule, une minuscule et avoir une longueur entre 2 et 10 caractères' ]])
            ->add('telephone', IntegerType::class, ['label' => 'Téléphone : '])
            ->add('mail', RepeatedType::class, [
                'type' => EmailType::class,
                'invalid_message' => 'L\'adresse mail indiqué doit être identique.',
                'first_options' => ['label' => 'Email : '],
                'second_options' => ['label' => 'Confirmer Email : '],
            ])
            //Ajout d' un champs de formulaire supplémentaire
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,

                //Ajout d' une ligne non associé à l'objet qui sera prise en compte.
                'mapped' => false,
                'required' => false,
                'constraints' => [new Regex([
                        'pattern' =>"/^(?=.*[A-Z]).{4,10}$/",
                        'message' =>"Le mot de passe doit contenir une majuscule et avoir une longueur entre 4 et 10 caratères"]
                )],
                'first_options' => ['label' => 'Mot de passe : ','attr'=> ['title'=>'Le mot de passe doit contenir une majuscule et avoir une longueur entre 4 et 10 caractères']],
                'second_options' => ['label' => 'Confirmer Mot de passe : ','attr'=> ['title'=>'Le mot de passe doit contenir une majuscule et avoir une longueur entre 4 et 10 caractères']]
            ])
            ->add('site', TextType::class, ['label' => 'Site de rattachement : '])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
