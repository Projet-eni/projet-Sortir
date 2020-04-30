<?php

namespace App\Entity;



class Filtre {


    private $fSite;


    private $search;


    private $dateDebut;

    private $dateFin;

    private $checkboxOrganisateur;

    private $checkboxInscrit;

    private $checkboxNonInscrit;


    private $checkboxSortiesPassees;


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
    public function setSearch($search)
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
    public function getCheckboxOrganisateur()
    {
        return $this->checkboxOrganisateur;
    }

    /**
     * @param mixed $checkboxOrganisateur
     */
    public function setCheckboxOrganisateur($checkboxOrganisateur)
    {
        $this->checkboxOrganisateur = $checkboxOrganisateur;
    }

    /**
     * @return mixed
     */
    public function getCheckboxInscrit()
    {
        return $this->checkboxInscrit;
    }

    /**
     * @param mixed $checkboxInscrit
     */
    public function setCheckboxInscrit($checkboxInscrit)
    {
        $this->checkboxInscrit = $checkboxInscrit;
    }

    /**
     * @return mixed
     */
    public function getCheckboxNonInscrit()
    {
        return $this->checkboxNonInscrit;
    }

    /**
     * @param mixed $checkboxNonInscrit
     */
    public function setCheckboxNonInscrit($checkboxNonInscrit)
    {
        $this->checkboxNonInscrit = $checkboxNonInscrit;
    }

    /**
     * @return mixed
     */
    public function getCheckboxSortiesPassees()
    {
        return $this->checkboxSortiesPassees;
    }

    /**
     * @param $checkboxSortiesPassees
     */
    public function setCheckboxSortiesPassees($checkboxSortiesPassees)
    {
        $this->checkboxSortiesPassees = $checkboxSortiesPassees;
    }




}

