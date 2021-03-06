<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\CsvType;
use App\Form\ModifParticipantType;
use App\Form\SiteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * Class ParticipantController
 * @package App\Controller
 * @Route("/user")
 */
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
    public function afficherProfil(Participant $participant, EntityManagerInterface $em, Request $request)
    {
        $siteForm = $this->createForm(SiteType::class, $participant);
        $siteForm->handleRequest($request);
        if ($siteForm->isSubmitted() && $siteForm->isValid())
        {
            $em->persist($participant);
            $em->flush();
            $this->addFlash('success', 'Le site de rattachement a bien été modifié');
            return $this->redirectToRoute('main');
        }
        return $this->render('participant/profil.html.twig', ['p'=>$participant, 'siteForm'=>$siteForm->createView()]);
    }

    /**
     * @Route("/importer", name="importer")
     */
    public function importerUtilisateur(Request $request, SluggerInterface $slugger)
    {
        $importForm = $this->createForm(CsvType::class);
        $importForm->handleRequest($request);

        if ($importForm->isSubmitted() && $importForm->isValid()) {

            $csvFile = $importForm->get('csvFile')->getData();

            if ($csvFile) {
                $originalFilename = pathinfo($csvFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $csvFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $csvFile->move(
                        $this->getParameter('csv_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                    $this->addFlash('success', 'an error occured during file upload');
                }
                $this->addFlash('success', 'Votre fichier a été enregistré avec succès. Le nom du fichier est : '.$newFilename);
            }
        }

        return $this->render('participant/importerFichier.html.twig', [ 'importForm' => $importForm->createView()]);
    }


}
