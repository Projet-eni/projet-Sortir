<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SortieRepository")
 */
class Sortie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $nom;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(propertyPath="dateLimiteInscription",
     *     message="La date de début ne peut pas être inférieure à la date de clôture des inscriptions")
     */
    private $dateHeureDebut;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Type("integer")
     * @Assert\NotBlank()
     */
    private $duree;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual("today", message="La date de clôture des inscriptions doit être supérieure à aujourd'hui")
     */
    private $dateLimiteInscription;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\Type("integer")
     */
    private $nbInscriptionsMax;

    /**
     * @ORM\Column(type="text")
     */
    private $infosSortie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Site",inversedBy="sorties")
     */
    private $site;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Participant",inversedBy="organisateur", cascade={"remove"})
     */
    private $sorties_organisees;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Participant", mappedBy="inscrits")
     */
    private $sortie_inscrits;

    public function __construct()
    {
        $this->sortie_inscrits = new ArrayCollection();
    }

    /**
     * @param $sortie_inscrits
     */
    public function addSortieInscrits($sortie_inscrits): void
    {
        if ($this->sortie_inscrits->contains($sortie_inscrits))
        {
            return;
        }
        $this->sortie_inscrits->add($sortie_inscrits);
    }

    public function removeSortieInscrits($sortie_inscrits): void
    {
        if ($this->sortie_inscrits->contains($sortie_inscrits))
        {
            $this->sortie_inscrits->removeElement($sortie_inscrits);
        }
        return;
    }

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lieu", inversedBy="sorties_lieu")
     */
    private $lieu;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Etat", inversedBy="sortie")
     */
    private $etat;

    /**
     * @return mixed
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @param mixed $site
     */
    public function setSite($site): void
    {
        $this->site = $site;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateHeureDebut(): ?\DateTimeInterface
    {
        return $this->dateHeureDebut;
    }

    public function setDateHeureDebut(\DateTimeInterface $dateHeureDebut): self
    {
        $this->dateHeureDebut = $dateHeureDebut;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDateLimiteInscription(): ?\DateTimeInterface
    {
        return $this->dateLimiteInscription;
    }

    public function setDateLimiteInscription(\DateTimeInterface $dateLimiteInscription): self
    {
        $this->dateLimiteInscription = $dateLimiteInscription;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNbInscriptionsMax()
    {
        return $this->nbInscriptionsMax;
    }

    /**
     * @param mixed $nbInscriptionsMax
     */
    public function setNbInscriptionsMax($nbInscriptionsMax): void
    {
        $this->nbInscriptionsMax = $nbInscriptionsMax;
    }

    public function getInfosSortie(): ?string
    {
        return $this->infosSortie;
    }

    public function setInfosSortie(string $infosSortie): self
    {
        $this->infosSortie = $infosSortie;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * @param mixed $lieu
     */
    public function setLieu($lieu): void
    {
        $this->lieu = $lieu;
    }

    /**
     * @return mixed
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param mixed $etat
     */
    public function setEtat($etat): void
    {
        $this->etat = $etat;
    }

    /**
     * @return mixed
     */
    public function getSortieInscrits()
    {
        return $this->sortie_inscrits;
    }

    /**
     * @param mixed $sortie_inscrits
     */
    public function setSortieInscrits($sortie_inscrits): void
    {
        $this->sortie_inscrits = $sortie_inscrits;
    }

    /**
     * @return mixed
     */
    public function getSortiesOrganisees()
    {
        return $this->sorties_organisees;
    }

    /**
     * @param mixed $sorties_organisees
     */
    public function setSortiesOrganisees($sorties_organisees): void
    {
        $this->sorties_organisees = $sorties_organisees;
    }



}
