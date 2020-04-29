<?php

namespace App\Controller;

use App\Data\FiltreRechecheSortie;
use App\Entity\Sortie;
use App\Form\FiltreRecherche;
use App\Form\SortieType;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    /**
     * @Route("/liste-sortie", name="liste-sortie")
     */
    public function index(SortieRepository $repository, Request $request)
    {

        $this->denyAccessUnlessGranted("ROLE_USER");

        $participant = $this->getUser();
        $filtre = new FiltreRechecheSortie();

        $form = $this->createForm(FiltreRecherche::class,$filtre);
        $form->handleRequest($request);

        $sorties = $repository->rechercheParSite($filtre);

        return $this->render('sortie/listeSortie.html.twig',['participant'=>$participant,'sorties'=>$sorties,'filtreForm'=>$form->createView()]);
    }

    /**
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/ajouter-sortie", name="ajouterSortie")
     */
    public function creerSortie(EntityManagerInterface $em, Request $request)
    {
        $sortie = new Sortie();


        $sortieForm = $this->createForm(SortieType::class, $sortie);

        $sortieForm->handleRequest($request);
        if ($sortieForm->isSubmitted() && $sortieForm->isValid())
        {
            $em->persist($sortie);
            $em->flush();
            $this->addFlash('success', 'Votre sortie a bien été créée');
            $this->redirectToRoute("liste-sortie");
        }

        return $this->render('sortie/ajoutSortie.html.twig', ['sortieForm' => $sortieForm->createView()]);
    }

    /**
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *@Route("/afficher-sortie/{id}", name="afficherSortie")
     */
    public function afficherSortie(Sortie $sortie){

        return $this->render('sortie/afficherSortie.html.twig', ['sorties' => $sortie]);
    }

    /**
     * @param EntityManagerInterface $em
     * @param Sortie $sortie
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/inscription{id}", name="inscription")
     */
    public function inscription(EntityManagerInterface $em, Sortie $sortie){

        $user = $this->getUser();
        $user->addInscrits($sortie);
        $sortie->addSortieInscrits($user);
        $em->flush();
        $this->addFlash('success', 'Vous avez bien été inscrits à cette sortie');

       return $this->render('sortie/afficherSortie.html.twig', ['sorties' => $sortie]);
    }







}
