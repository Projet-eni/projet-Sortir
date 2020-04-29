<?php

namespace App\Data;

class FiltreRechecheSortie {


    private $sortie;


    private $fSite;



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


}

