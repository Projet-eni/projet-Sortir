<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\GestionAdminType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
            }elseif (isset($_POST['supprime'])) {
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
}
