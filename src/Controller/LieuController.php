<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Entity\Ville;
use App\Form\LieuType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LieuController
 * @package App\Controller
 * @Route("/user")
 */
class LieuController extends AbstractController
{
    /**
     * @Route("/liste-lieux/{id}", name="liste-lieux")
     * route AJAX
     */
    public function listeLieux($id)
    {
        $repo = $this->getDoctrine()->getRepository(Lieu::class);
        $lieu = $repo->find($id);
        $tab= [];
        $status = 404;
        if($lieu != null){
            $tab = ['ville' => $lieu->getVille()->getNom(),
                    'rue' => $lieu->getRue(),
                    'codePostal' => $lieu->getVille()->getCodePostal(),
                    'latitude' => $lieu->getLatitude(),
                    'longitude' => $lieu->getLongitude()
                ];
            $status = 200;
        }
        return new JsonResponse($tab, $status);
    }

    /**
     * @Route("/ajoutLieu", name="ajoutLieu")
     */
    public function ajoutLieu(EntityManagerInterface $em, Request $request){
        $lieu = new Lieu();

        $lieuForm = $this->createForm(LieuType::class, $lieu);
        $lieuForm->handleRequest($request);
        if ($lieuForm->isSubmitted()&&$lieuForm->isValid()){
            $ville = new Ville();
            $ville->setNom($lieuForm->get('ville')->getData());
            $ville->setCodePostal($lieuForm->get('codePostal')->getData());
            $ville->addLieu($lieu);
            $lieu->setVille($ville);
            $em->persist($ville);
            $em->persist($lieu);
            $em->flush();
            $this->addFlash('success', 'Votre lieu est bien rajouté');
            return $this->redirectToRoute('ajouterSortie');
        }
        return $this->render('lieu/ajout.html.twig',[
            'lieuForm' => $lieuForm->createView()
        ]);
    }
}
