<?php

namespace App\Controller;


use App\Entity\Participant;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Form\GestionAdminType;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class AdminController
 * @package App\Controller
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        $user = new Participant();
        $userform = $this->createForm(GestionAdminType::class, $user);
        $userform->handleRequest($request);
        if ($userform->isSubmitted() && $userform->isValid()) {
            $user = $userform->get('participant')->getData();
            if (isset($_POST['desactive'])) {
                $user->setActif(false);
                $em->persist($user);
                $this->addFlash('success', 'L\'utilisateur est bien désactivé');
            }elseif (isset($_POST['reactiver'])) {
                $user->setActif(true);
                $em->persist($user);
                $this->addFlash('success', 'L\'utilisateur est bien réactiver');
            }elseif (isset($_POST['supprimer'])) {
                $em->remove($user);
                $this->addFlash('success', 'L\'utilisateur est bien supprimé');
            }
            $em->flush();
            $this->redirectToRoute('admin');
        }


        return $this->render('admin/gestion.html.twig', [
            'userForm' => $userform->createView(),
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
            $site = $inscriptionForm->get('site')->getData();
            $participant->setSite($site);
            $participant->setRole(["ROLE_USER"]);
            $participant->setActif(true);
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
