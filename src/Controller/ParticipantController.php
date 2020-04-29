<?php

    namespace App\Controller;

    use App\Entity\Participant;
    use App\Form\ModifParticipantType;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

    class ParticipantController extends AbstractController
    {
        /**
         * @Route("/participant/update", name="participant_update")
         *Fonction qui attend un id d'utilisateur en session et la requête du formaulaire de datas
         * à mettre à jour en BDD.
         */

        //Mise à jour d'un participant par son id stocker en session.
        public function Update(Request $request, UserPasswordEncoderInterface $encoder)

        {//to do: tester si l user est connecter
            $participant = $this->getUser();
            $password = $participant->getPassword();

            // récupération et instanciation de l' utilisateur en session par son id
            $em = $this->getDoctrine()->getManager();
            $participant = $em->getRepository(Participant::class)->find($participant);

            $modifParticipantForm = $this->createForm(ModifParticipantType::class, $participant);
            //partie controle du fomulaire
            $modifParticipantForm->handleRequest($request);
            //modification sile formulaire est valide et envoyé
            if ($modifParticipantForm->isSubmitted() && $modifParticipantForm->isValid()) {

                /*modification du motDePasse*/

                if (empty($modifParticipantForm->get('plainPassword')->getData())) {
                    $participant->setMotDePasse($password);

                    //Récupère la valeur saisie dans le champ
                } elseif(!empty($modifParticipantForm->get('plainPassword')->getData())){
                    $plainPassword = $modifParticipantForm->get('plainPassword')->getData();
                    $participant->setMotDePasse($plainPassword);
                    //encode le password
                    $password = $encoder->encodePassword($participant, $participant->getMotDePasse());
                    $participant->setMotDePasse($password);
                }
                $em->persist($participant);
                $em->flush();
                ///affichage du message de succès de traitement
                $this->addFlash('success', "Vos données ont bien été mise à jour.");


            }
            return $this->render('participant/profil.html.twig', ['participantForm' => $modifParticipantForm->createView(),  'participant'=>$participant]);
        }


    }
