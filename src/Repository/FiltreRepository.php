<?php

namespace App\Repository;


use App\Data\FiltreRechecheSortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Etat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Etat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Etat[]    findAll()
 * @method Etat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FiltreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FiltreRechecheSortie::class);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function filtreRecherche($filtre)
    {
        return $this->createQueryBuilder('f')

            ->getQuery()
            ->getResult()
        ;
    }
}