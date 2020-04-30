<?php

    namespace App\Entity;

    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\ORM\Mapping as ORM;
    use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
    use Symfony\Component\Security\Core\User\UserInterface;
    use Symfony\Component\Validator\Constraints as Assert;

    /**
     * @ORM\Entity(repositoryClass="App\Repository\ParticipantRepository")
     * @UniqueEntity("pseudo", message="Ce pseudo est déjà utilisé.")
     */
    class Participant implements UserInterface
    {
        /**
         * @ORM\Id()
         * @ORM\GeneratedValue()
         * @ORM\Column(type="integer")
         */
        private $id;

        /**
         * @ORM\Column(type="string", length=255)
         */
        private $nom;

        /**
         * @ORM\Column(type="string", length=255)

         */
        private $motDePasse;
        /**
         * @ORM\Column(type="string", length=255)
         */
        private $prenom;
        /**
         * @ORM\Column(type="string", length=255)
         * @Assert\Regex(
         *pattern="/^(?=.*[A-Z]).{2,10}$/",
         * message="Votre pseudo doit contenir une majuscule et avoir une longueur entre 2 et 10 caratères"
         * )
         */
        private $pseudo;
        /**
         * @ORM\Column(type="integer", nullable=true)
         */
        private $telephone;
        /**
         * @ORM\ManyToMany(targetEntity="App\Entity\Sortie", inversedBy="sortie_inscrits")
         */
        private $inscrits;
        /**
         * @ORM\Column(type="string", length=255)
         */
        private $mail;
        /**
         * @ORM\Column(type="json")
         */
        private $role;
        /**
         * @ORM\ManyToOne(targetEntity="App\Entity\Site", inversedBy="participants")
         *
         */
        private $site;
        /**
         * @ORM\OneToMany(targetEntity="App\Entity\Sortie", mappedBy="sorties_organisees")
         */
        private $organisateur;

        public function __construct()
        {
            $this->inscrits = new ArrayCollection();
        }

        /**
         * @return mixed
         */
        public function getOrganisateur()
        {
            return $this->organisateur;
        }

        /**
         * @param mixed $organisateur
         */
        public function setOrganisateur($organisateur): void
        {
            $this->organisateur = $organisateur;
        }

        /**
         * @param mixed $inscrits
         */
        public function addInscrits($inscrits): void
        {
            if ($this->inscrits->contains($inscrits)) {
                return;
            }
            $this->inscrits->add($inscrits);
        }

        public function removeInscrits($inscrits): void
        {
            if ($this->inscrits->contains($inscrits)) {
                $this->inscrits->removeElement($inscrits);
            }
            return;
        }

        /**
         * @return mixed
         */
        public function getInscrits()
        {
            return $this->inscrits;
        }

        /**
         * @param mixed $inscrits
         */
        public function setInscrits($inscrits): void
        {
            $this->inscrits = $inscrits;
        }

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

        public function getPrenom(): ?string
        {
            return $this->prenom;
        }

        public function setPrenom(string $prenom): self
        {
            $this->prenom = $prenom;

            return $this;
        }

        public function getTelephone(): ?int
        {
            return $this->telephone;
        }

        public function setTelephone(?int $telephone): self
        {
            $this->telephone = $telephone;

            return $this;
        }

        public function getMail(): ?string
        {
            return $this->mail;
        }

        public function setMail(string $mail): self
        {
            $this->mail = $mail;

            return $this;
        }

        /**
         * @inheritDoc
         */
        public function getRoles()
        {
            return $this->getRole();
        }

        public function getRole(): ?array
        {
            return $this->role;
        }

        public function setRole(array $role): self
        {
            $this->role = $role;

            return $this;
        }

        /**
         * @inheritDoc
         */
        public function getPassword()
        {
            return $this->motDePasse;
        }

        /**
         * @return mixed
         */
        public function getMotDePasse()
        {
            return $this->motDePasse;
        }

        /**
         * @param mixed $motDePasse
         */
        public function setMotDePasse($motDePasse): void
        {
            $this->motDePasse = $motDePasse;
        }

        /**
         * @inheritDoc
         */
        public function getSalt()
        {
        }

        /**
         * @inheritDoc
         */
        public function getUsername()
        {
            return $this->getPseudo();
            //$this->getMail();
        }

        /**
         * @return mixed
         */
        public function getPseudo()
        {
            return $this->pseudo;
        }

        /**
         * @param mixed $pseudo
         */
        public function setPseudo($pseudo): void
        {
            $this->pseudo = $pseudo;
        }

        /**
         * @inheritDoc
         */
        public function eraseCredentials()
        {
        }
    }
