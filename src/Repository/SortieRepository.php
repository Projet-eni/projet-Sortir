<?php

namespace App\Repository;

use App\Entity\Filtre;
use App\Entity\Participant;
use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    /**
     * @return Sortie[] Returns an array of Sortie objects
     */
    public function filtreRecherche(Filtre $filtre, Participant $participant)
    {

        $query = $this->createQueryBuilder('s');

        if($filtre->getFSite()!==null){
            $query = $query
                ->andWhere('s.site = :site')
                ->setParameter('site',$filtre->getFSite()->getId());
        }

        //requete filtre résultat barre de recherche.
        if ($filtre->getSearch() !== null) {
            $query = $query
                ->andWhere('s.nom LIKE :search')
                ->setParameter('search', '%'.$filtre->getSearch().'%');
        }

        //requete filtre en fonction des dates rentrées.
        if ($filtre->getDateDebut() !== null && $filtre->getDateFin() !== null) {
            $query = $query
                ->andWhere('s.dateHeureDebut BETWEEN :start AND :end')
                ->setParameter('start', $filtre->getDateDebut())
                ->setParameter('end', $filtre->getDateFin());
        } elseif ($filtre->getDateDebut() !== null && $filtre->getDateFin() == null) {
            $query = $query
                ->andWhere('s.dateHeureDebut >= :startSeul')
                ->setParameter('startSeul', $filtre->getDateDebut());
        } elseif ($filtre->getDateDebut() == null && $filtre->getDateFin() !== null) {
            $query = $query
                ->andWhere('s.dateHeureDebut <= :endSeul')
                ->setParameter('endSeul', $filtre->getDateFin());
        }

            //requete checkbox si le participant en session est organisateur
            if ($filtre->getCheckboxOrganisateur() == true) {
                $query = $query
                    ->andWhere('s.site = :siteCheckOr AND s.sorties_organisees = :siteCheckOr2')
                    ->setParameter('siteCheckOr', $filtre->getFSite()->getId())
                    ->setParameter('siteCheckOr2', $participant->getId());
            }

            //requete checkbox si le participant en session est inscrit
            if ($filtre->getCheckboxInscrit() == true) {
                $query = $query
                    ->addSelect('i')
                    ->join('s.sortie_inscrits', 'i')
                    ->andWhere('i.id = :siteCheckIns AND s.site = :siteCheckIns2')
                    ->setParameter('siteCheckIns', $participant->getId())
                    ->setParameter('siteCheckIns2', $filtre->getFSite()->getId());
            }

            //requete checkbox si le participant en session n' est pas inscrit
            if ($filtre->getCheckboxNonInscrit() == true) {
                $query = $query
                    ->addSelect('i')
                    ->join('s.sortie_inscrits', 'i')
                    ->andWhere('i.id != :siteCheckNonIns AND s.site = :siteCheckNonIns2')
                    ->setParameter('siteCheckNonIns', $participant->getId())
                    ->setParameter('siteCheckNonIns2', $filtre->getFSite()->getId());
            }

            //requete checkbox si les sorties sont en état passées
            if ($filtre->getCheckboxSortiesPassees() == true) {
                $query = $query
                    ->andWhere('s.etat = 4 AND s.site = :CheckSortPass')
                    ->setParameter('CheckSortPass', $filtre->getFSite()->getId());
            }


        return $query->getQuery()->getResult();

    }
}
