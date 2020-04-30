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

        //requete filtre par rapport au site.
        if ($filtre->getFSite() !== null) {
            $query = $query
                ->andWhere('s.site = :key')
                ->setParameter('key', $filtre->getFSite()->getId());
        }

        //requete filtre résultat barre de recherche.
        if ($filtre->getSearch() !== null) {

            $query = $query
                ->andWhere('s.nom LIKE :key ')
                ->setParameter('key', "%{$filtre->getSearch()}%");
        }

        //requete filtre en fonction des dates rentrées.
        if ($filtre->getDateDebut() !== null && $filtre->getDateFin() !== null) {
            $query = $query
                ->andWhere('s.dateHeureDebut BETWEEN :start AND :end')
                ->setParameter('start', $filtre->getDateDebut())
                ->setParameter('end', $filtre->getDateFin());
        } elseif ($filtre->getDateDebut() !== null && $filtre->getDateFin() == null) {
            $query = $query
                ->andWhere('s.dateHeureDebut >= :start')
                ->setParameter('start', $filtre->getDateDebut());
        } elseif ($filtre->getDateDebut() == null && $filtre->getDateFin() !== null) {
            $query = $query
                ->andWhere('s.dateHeureDebut <= :end')
                ->setParameter('end', $filtre->getDateFin());
        }

        //requete checkbox si le participant en session est organisateur
        if ($filtre->getCheckboxOrganisateur() == true) {
            $query = $query
                ->andWhere('s.sorties_organisees = :key')
                ->setParameter('key', $participant->getId());
        }

        //requete checkbox si le participant en session est inscrit
        if ($filtre->getCheckboxInscrit() == true) {
            $query = $query
                ->join('s.sortie_inscrits', 'i')
                ->addSelect('i')
                ->where('i.id = :key')
                ->setParameter('key', $participant->getId());
        }

        //requete checkbox si le participant en session n' est pas inscrit
        if ($filtre->getCheckboxNonInscrit() == true) {
            $query = $query
                ->join('s.sortie_inscrits', 'i')
                ->addSelect('i')
                ->where('i.id != :key')
                ->setParameter('key', $participant->getId());

        }

        //requete checkbox si les sorties sont en état passées
        if ($filtre->getCheckboxSortiesPassees() == true) {
            $query = $query
                ->andWhere('s.etat = 4');

        }

        return $query->getquery()->getResult();
    }
}
