<?php

namespace App\Controller;

use App\Entity\Sortie;
use PhpParser\Node\Expr\New_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    /**
     * @Route("/liste-sortie", name="liste-sortie")
     */
    public function index()
    {

       $repository= $this->getDoctrine()->getRepository(Sortie::class);

        $sorties = $repository->findAll();



        return $this->render('sortie/listeSortie.html.twig',['sorties'=>$sortie]);
    }
}
