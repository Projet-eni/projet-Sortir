<?php

namespace App\Controller;

use App\Data\FiltreRechecheSortie;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Form\SortieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    /**
     * @Route("/liste-sortie", name="liste-sortie")
     */
    public function index(ProductRepository $repository, Request $request)
    {

        $filtre = new FiltreRechecheSortie();

        $form = $this->createForm(FiltreRechecheSortie::class,$filtre);
        $form->handleRequest($request);
        $sorties = $repository->filtreRecherche($filtre);

        return $this->render('sortie/listeSortie.html.twig',['sorties'=>$sorties,$form->createView()]);

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
        if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {
            $em->persist($sortie);
            $em->flush();
            $this->addFlash('success', 'Votre sortie a bien été créée');
            $this->redirectToRoute("liste-sortie");
        }

        return $this->render('sortie/ajoutSortie.html.twig', ['sortieForm' => $sortieForm->createView()]);
    }
}
