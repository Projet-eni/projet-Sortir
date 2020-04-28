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


    class ModifParticipantType extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $options)
        {
            $builder
                ->add('nom', TextType::class, ['label' => 'nom'])
                ->add('prenom', TextType::class, ['label' => 'prenom'])
                ->add('pseudo', TextType::class, ['label' => 'pseudo'])
                ->add('telephone', IntegerType::class, ['label' => 'telephone'])
                ->add('mail', RepeatedType::class, [
                    'type' => EmailType::class,
                    'invalid_message' => 'L\'adresse mail indiqué doit être identique.',
                    'first_options' => ['label' => 'Email'],
                    'second_options' => ['label' => 'Confirmer Email']
                ])
                //Ajout d' un champs de formulaire supplémentaire
                ->add('plainPassword', RepeatedType::class, [
                    'type' => PasswordType::class,
                    //Ajout d' une ligne non associé a l'objet qui sera prise en compte.
                    'mapped' => false,
                    'first_options' => ['label' => 'Mot de passe'],
                    'second_options' => ['label' => 'Confirmer Mot de passe']
                ]);

        }

        public function configureOptions(OptionsResolver $resolver)
        {
            $resolver->setDefaults([
                'data_class' => Participant::class,
            ]);
        }
    }
