<?php

namespace App\Controller;

use App\Data\FiltreRechecheSortie;
use App\Entity\Etat;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Form\AnnulSortieType;
use App\Form\FiltreRecherche;
use App\Form\SortieType;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Filtre;
use App\Form\FiltreType;

/**
 * Class SortieController
 * @package App\Controller
 * @Route("/user")
 */
class SortieController extends AbstractController
{

    /**
     * @Route("/liste-sortie", name="liste-sortie")
     */
    public function index(SortieRepository $repository, Request $request)
    {
        $this->denyAccessUnlessGranted("ROLE_USER");
        $participant = $this->getUser();
        $filtre = new Filtre();
        $form = $this->createForm(FiltreType::class,$filtre);
        $form->handleRequest($request);
        $sorties = $repository->filtreRecherche($filtre, $participant);

        return $this->render('sortie/listeSortie.html.twig',['participant'=>$participant,'sorties'=>$sorties,
            'filtreForm'=>$form->createView()]);
    }


    /**
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     * @Route("/ajouter-sortie", name="ajouterSortie")
     */
    public function creerSortie(EntityManagerInterface $em, Request $request)
    {
        /**
         * @var Participant $user
         */
        $user = $this->getUser();
        $sortie = new Sortie();
        $sortie->setSortiesOrganisees($this->getUser());
        $sortie->setSite($user->getSite());



        $sortieForm = $this->createForm(SortieType::class, $sortie);

        $sortieForm->handleRequest($request);
        if ($sortieForm->isSubmitted() && $sortieForm->isValid())
        {
            if (isset($_POST['enr'])) {
                $idetat = 1;
            } elseif (isset($_POST['pub'])) {
                $idetat = 6;
            }
            $repo = $this->getDoctrine()->getRepository(Etat::class);
            $etat = $repo->find($idetat);
            $sortie->setEtat($etat);
            $em->persist($sortie);
            $em->flush();
            $this->addFlash('success', 'Votre sortie a bien été créée');
            return $this->redirectToRoute("liste-sortie");
        }

        return $this->render('sortie/ajoutSortie.html.twig', ['sortieForm' => $sortieForm->createView(), 's'=>$sortie]);
    }

    /**
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     * @Route("/modifier-sortie/{id}", name="modifierSortie")
     */
    public function modifierSortie(Sortie $sortie, EntityManagerInterface $em, Request $request)
    {
        $sortieForm = $this->createForm(SortieType::class, $sortie);

        $sortieForm->handleRequest($request);
        if ($sortieForm->isSubmitted() && $sortieForm->isValid())
        {
            $idetat = null;
            if (isset($_POST['enr'])) {
                $idetat = 1;
            } elseif (isset($_POST['pub'])) {
                $idetat = 6;
            }
            if ($idetat!=null) {
                $repo = $this->getDoctrine()->getRepository(Etat::class);
                $etat = $repo->find($idetat);
                $sortie->setEtat($etat);
                $em->persist($sortie);
                $em->flush();
                $this->addFlash('success', 'Votre sortie a bien été créée');
            }
            return $this->redirectToRoute("liste-sortie");
        }

        return $this->render('sortie/ajoutSortie.html.twig', ['sortieForm' => $sortieForm->createView(), 's'=>$sortie]);
    }

    /**
     *
     * @return Response
     *@Route("/afficher-sortie/{id}", name="afficherSortie")
     */
    public function afficherSortie(Sortie $sortie){
        $user = $this->getUser();
        return $this->render('sortie/afficherSortie.html.twig', ['sortie' => $sortie, 'user' => $user]);
    }

    /**
     * @param EntityManagerInterface $em
     * @param Sortie $sortie
     * @return Response
     * @Route("/inscription{id}", name="inscription")
     */
    public function inscription(EntityManagerInterface $em, Sortie $sortie){

        $user = $this->getUser();

        if($sortie->getEtat()->getId() != 6) {
            $this->addFlash('success', 'Le statut de la sortie n\'est pas ouvert');
        }
        elseif ($sortie->getDateLimiteInscription() < date("d/m/Y")) {
            $this->addFlash('success', 'La date limite des inscriptions est passée');
        }
        elseif ($sortie->getSortieInscrits()->count() >= $sortie->getNbInscriptionsMax()){
            $this->addFlash('success', 'Le nombre maximal d\'inscription a déjà été atteint');
        }
        else {
            $user->addInscrits($sortie);
            $sortie->addSortieInscrits($user);
            $em->flush();
            $this->addFlash('success', 'Vous avez bien été inscrit à cette sortie');
        }
       return $this->render('sortie/afficherSortie.html.twig', ['sortie' => $sortie, 'participant' => $user]);
    }

    /**
     * @param EntityManagerInterface $em
     * @param Sortie $sortie
     * @return Response
     * @Route("/desistement{id}", name="desistement")
     */
    public function seDesister(EntityManagerInterface $em, Sortie $sortie){

        if($sortie->getDateHeureDebut() > date("d/m/Y")){
            $user = $this->getUser();
            $user->removeInscrits($sortie);
            $sortie->removeSortieInscrits($user);
            $em->flush();
            $this->addFlash('success', 'Vous vous êtes désisté');
        }
        else {
            $this->addFlash('success', 'La sortie a débuté, vous ne pouvez plus vous désister');
        }

        return $this->render('sortie/afficherSortie.html.twig', ['sortie' => $sortie]);
    }

    /**
     * @param Sortie $sortie
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     * @Route("/annuler{id}", name="annuler")
     */
    public function annuler(Sortie $sortie, EntityManagerInterface $em, Request $request){

        $user = $this->getUser();

        $annulSortieForm = $this->createForm(AnnulSortieType::class, $sortie);

        $annulSortieForm->handleRequest($request);
        $idetat=null;
        if ($annulSortieForm->isSubmitted() && $annulSortieForm->isValid()){
            if (isset($_POST['enr'])) {
                $motif = $annulSortieForm->get('infosSortie')->getData();
                $idetat = 5;
            }
            if ($idetat!=null) {
                $repo = $this->getDoctrine()->getRepository(Etat::class);
                $etat = $repo->find($idetat);
                $sortie->setEtat($etat);
                $sortie->setInfosSortie($motif);
                $em->persist($sortie);
                $em->flush();
                $this->addFlash('success', 'Votre sortie a bien été annulée');
            }
            return $this->redirectToRoute("liste-sortie");
        }

        return $this->render('sortie/annulerSortie.html.twig', ['sortie' => $sortie, 'annulSortieForm' => $annulSortieForm->createView()]);
    }



}
