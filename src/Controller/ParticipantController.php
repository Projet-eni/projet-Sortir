<?php

    namespace App\Controller;

    use App\Entity\Participant;
    use App\Form\ModifParticipantType;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Annotation\Route;

    class ParticipantController extends AbstractController
    {
        /**
         * @Route("/participant/update", name="participant_update")
         *Fonction qui attend un id d'utilisateur en session et la requête du formaulaire de datas
         * à mettre à jour en BDD.
         */

        //Mise à jour d'un participant par son id stocker en session.
        public function Update(Request $request)

        {//to do: tester si l user est connecter
            $participant = $this->getUser();
            // récupération et instanciation de l' utilisateur en session par son id
            $em = $this->getDoctrine()->getManager();
            $participant = $em->getRepository(Participant::class)->find(1);

            $ModifParticipantForm = $this->createForm(ModifParticipantType::class, $participant);
            //partie controle du fomulaire
            $ModifParticipantForm->handleRequest($request);
            //modification sile formulaire est valide et envoyé
            if ($ModifParticipantForm->isSubmitted() && $ModifParticipantForm->isValid()) {
                //Traitement
                //nom

                /* prénom,

                pseudo,

                email,

                mot de passe,

                 et téléphone

                 . Le pseudo doit être unique
                 entre tous les participants.

                */
                //Récupère la valeur saisie dans le champ
                $plainPassword = $ModifParticipantForm->get('plainPassword')->getData();
                //to do :si le champs n'est pas null et pas vide on l' encode et enregistre en bdd

                $em->persist($participant);
                $em->flush();
                //affichage du message de succès de traitement
                //$this->addFlash('success', "Vos données ont bien été mise à jour.");
            }
            return $this->render('participant/profil.html.twig', ['participantForm' => $ModifParticipantForm->createView()]);
        }


    }
