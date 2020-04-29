<?php

namespace App\Controller;

use App\Entity\Lieu;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

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
}
