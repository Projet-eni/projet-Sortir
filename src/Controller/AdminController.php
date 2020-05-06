<?php

namespace App\Controller;


use App\Entity\Participant;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Form\InscriptionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @param Request $resquest
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     * @Route("/inscrireAdmin", name="inscrireAdmin")
     */
    public function inscrireUtilisateur(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $participant = new Participant();

        // récupération et instanciation de l' utilisateur en session par son id
        $em = $this->getDoctrine()->getManager();

        $inscriptionForm = $this->createForm(InscriptionType::class, $participant);

        $inscriptionForm ->handleRequest($request);

        if($inscriptionForm->isSubmitted() && $inscriptionForm->isValid())
        {
            $nomSite = $inscriptionForm->get('site')->getData();
            $repo = $repo = $this->getDoctrine()->getRepository(Site::class);
            $site = $repo->findOneBy([
                'nom' => $nomSite
            ]);
            $participant->setSite($site);
            $participant->setRole(["ROLE_USER"]);
            //encode le password
            $password = $encoder->encodePassword($participant, $inscriptionForm->get('plainPassword')->getData());
            $participant->setMotDePasse($password);

            $em->persist($participant);
            $em->flush();
            ///affichage du message de succès de traitement
            $this->addFlash('success', "Un nouvel utilisateur a bien été créé.");
        }

        return $this->render('admin/inscrire.html.twig', ['inscriptionForm' => $inscriptionForm->createView()]);
    }
}
