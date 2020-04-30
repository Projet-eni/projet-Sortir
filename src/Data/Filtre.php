<?php

namespace App\Data;

class FiltreRechecheSortie {

    /**
     * @var
     */
    private $sortie;

    /**
     * @var
     */
    private $fSite;

    /**
     * @var
     */
    private $search;

    /**
     * @var
     */
    private $dateDebut;

    /**
     * @var
     */
    private $dateFin;

    /**
     * @var
     */
    private $checkbox;



    /**
     * @return mixed
     */
    public function getSortie()
    {
        return $this->sortie;
    }

    /**
     * @param mixed $sortie
     */
    public function setSortie($sortie): void
    {
        $this->sortie = $sortie;
    }

    /**
     * @return mixed
     */
    public function getFSite()
    {
        return $this->fSite;
    }

    /**
     * @param $fSite
     */
    public function setFSite($fSite)
    {
        $this->fSite = $fSite;
    }

    /**
     * @return mixed
     */
    public function getSearch()
    {
        return $this->search;
    }

    /**
     * @param mixed $search
     */
    public function setSearch($search): void
    {
        $this->search = $search;
    }

    /**
     * @return mixed
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * @param mixed $dateDebut
     */
    public function setDateDebut($dateDebut): void
    {
        $this->dateDebut = $dateDebut;
    }

    /**
     * @return mixed
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * @param mixed $dateFin
     */
    public function setDateFin($dateFin): void
    {
        $this->dateFin = $dateFin;
    }
    /**
     * @return mixed
     */
    public function getCheckbox()
    {
        return $this->checkbox;
    }

    /**
     * @param mixed $checkbox
     */
    public function setCheckbox($checkbox): void
    {
        $this->checkbox = $checkbox;
    }


}

