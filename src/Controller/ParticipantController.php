<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\CsvType;
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

    {
        $participant = $this->getUser();

        // récupération et instanciation de l' utilisateur en session par son id
        $em = $this->getDoctrine()->getManager();

        $modifParticipantForm = $this->createForm(ModifParticipantType::class, $participant);
        //partie controle du fomulaire
        $modifParticipantForm->handleRequest($request);
        //modification sile formulaire est valide et envoyé
        if ($modifParticipantForm->isSubmitted() && $modifParticipantForm->isValid()) {

            /*modification du motDePasse*/


            //Récupère la valeur saisie dans le champ
            if (!empty($modifParticipantForm->get('plainPassword')->getData())) {
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
        return $this->render('participant/modifProfil.html.twig', ['participantForm' => $modifParticipantForm->createView(), 'participant' => $participant]);
    }

    /**
     * @Route("/afficherProfil/{id}", name="afficherProfil")
     */
    public function afficherProfil(Participant $participant)
    {
        // lien a mettre pour accéder à la route :
        // <a href="{{ path('afficherProfil',{'id' : p.id }) }}"><h3>{{ p.titre }}</h3></a>
        return $this->render('participant/profil.html.twig', ['p'=>$participant]);
    }

    /**
     * @Route("/importer", name="importer")
     */
    public function importerUtilisateur(Request $request)
    {
        $participant = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $importForm = $this->createForm(CsvType::class, $participant);
        $importForm->handleRequest($request);

        if($importForm->isSubmitted() && $importForm->isValid()){
            if(!empty($importForm->get('csvFile')->getData())){
                $csvFile = $importForm->get('csvFile')->getData();
                $participant->setCsvFile($csvFile);
                $this->addFlash('success', "Le fichier a bien été uploadé, veuillez utiliser la commande csv:import pour importer le fichier dans la BDD");
            }
            else {
                $this->addFlash('success', "Veuillez enregistrer un fichier .csv valide");
            }
            $em->persist($participant);
            $em->flush();
        }

        return $this->render('participant/importerFichier.html.twig', [ 'importForm' => $importForm->createView(), 'participant' => $participant]);
    }


}
