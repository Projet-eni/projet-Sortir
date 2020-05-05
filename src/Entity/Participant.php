<?php

    namespace App\Entity;

    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\ORM\Mapping as ORM;
    use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
    use Symfony\Component\Security\Core\User\UserInterface;
    use Symfony\Component\Validator\Constraints as Assert;
    use Symfony\Component\HttpFoundation\File\File;
    use Symfony\Component\HttpFoundation\File\UploadedFile;
    use Vich\UploaderBundle\Entity\File as EmbeddedFile;
    use Vich\UploaderBundle\Mapping\Annotation as Vich;

    /**
     * @ORM\Entity(repositoryClass="App\Repository\ParticipantRepository")
     * @UniqueEntity("pseudo", message="Ce pseudo est déjà utilisé.")
     * @Vich\Uploadable
     */
    class Participant implements UserInterface, \Serializable
    {
        //-------------------attributs---------------------//
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
         * pattern="/^(?=.*[a-z])(?=.*[A-Z]).{2,10}$/",
         * message="Votre pseudo doit contenir une majuscule, une minuscule et avoir une longueur entre 2 et 10 caractères"
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

        /**
         * @ORM\Column(type="string", length=255, nullable=true)
         * @var string
         */
        private $image;

        /**
         * @Vich\UploadableField(mapping="participant", fileNameProperty="image")
         * @var File
         */
        private $imageFile;

        /**
         * @ORM\Column(type="datetime", nullable=true)
         * @var \DateTime
         */
        private $updatedAt;


        //-------------------constructeurs---------------------//

        public function __construct()
        {
            $this->inscrits = new ArrayCollection();
        }
        //-------------------méthodes---------------------//

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
        //-------------------getters/setters---------------------//
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
        public function setSite($site): self
        {
            $this->site = $site;

            return $this;
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
            return $this->getMotDePasse();
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
        public function setMotDePasse($motDePasse): self
        {
            $this->motDePasse = $motDePasse;

            return $this;
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
        public function setPseudo($pseudo): self
        {
            $this->pseudo = $pseudo;

            return $this;
        }

        /**
         * @inheritDoc
         */
        public function eraseCredentials()
        {
        }

        public function setImageFile(File $image = null)
        {
            $this->imageFile = $image;

            // VERY IMPORTANT:
            // It is required that at least one field changes if you are using Doctrine,
            // otherwise the event listeners won't be called and the file is lost
            if ($image) {
                // if 'updatedAt' is not defined in your entity, use another property
                $this->updatedAt = new \DateTime('now');
            }
        }

        public function getImageFile()
        {
            return $this->imageFile;
        }

        public function setImage($image)
        {
            $this->image = $image;
        }

        public function getImage()
        {
            return $this->image;
        }

        /**
         * @inheritDoc
         */
        public function serialize()
        {
            return serialize([
                $this->id,
                $this->nom,
                $this->motDePasse,
                $this->prenom,
                $this->pseudo,
                $this->telephone,
                $this->inscrits,
                $this->mail,
                $this->role,
                $this->site,
                $this->organisateur,
                $this->image,
                $this->updatedAt,
            ]);
        }

        /**
         * @inheritDoc
         */
        public function unserialize($serialized)
        {
            list (
                $this->id,
                $this->nom,
                $this->motDePasse,
                $this->prenom,
                $this->pseudo,
                $this->telephone,
                $this->inscrits,
                $this->mail,
                $this->role,
                $this->site,
                $this->organisateur,
                $this->image,
                $this->updatedAt,
                ) = unserialize($serialized, ['allowed_classes' => false]);
        }
    }
