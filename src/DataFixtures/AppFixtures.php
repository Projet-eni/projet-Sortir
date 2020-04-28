<?php

namespace App\DataFixtures;

use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $etat = new Etat();
        $etat->setLibelle('Créée');
        $manager->persist($etat);
        $etat = new Etat();
        $etat->setLibelle('Clôturée');
        $manager->persist($etat);
        $etat = new Etat();
        $etat->setLibelle('Activité en cours');
        $manager->persist($etat);
        $etat = new Etat();
        $etat->setLibelle('Passée');
        $manager->persist($etat);
        $etat = new Etat();
        $etat->setLibelle('Annulée');
        $manager->persist($etat);
        $etat = new Etat();
        $etat->setLibelle('Ouverte');
        $manager->persist($etat);



        $ville = new Ville();
        $ville->setNom('La Roche sur Yon');
        $ville->setCodePostal(85000);
        $manager->persist($ville);

        $lieu = new Lieu();
        $lieu->setNom('ENI Ecole');
        $lieu->setRue('19 Avenue Léo Lagrange');
        $lieu->setLatitude(46.3160155);
        $lieu->setLongitude(-0.4713764);
        $ville = new Ville();
        $ville->setNom('Niort');
        $ville->setCodePostal(79000);
        $manager->persist($ville);
        $lieu->setVille($ville);
        $manager->persist($lieu);
        $lieu = new Lieu();
        $lieu->setNom('ENI Ecole');
        $lieu->setRue('3 rue Michael Faraday');
        $lieu->setLatitude(47.2258547);
        $lieu->setLongitude(-1.6200333);
        $ville = new Ville();
        $ville->setNom('Saint-Herblain');
        $ville->setCodePostal(44800);
        $lieu->setVille($ville);
        $manager->persist($ville);
        $manager->persist($lieu);

        $participant = new Participant();
        $participant->setNom('LOESEL');
        $participant->setPrenom('Pierre');
        $participant->setPseudo('Skullpie');
        $participant->setMotDePasse('test1234');
        $participant->setRole('USER_ROLE');
        $participant->setMail('pierre@hotmail.fr');
        $participant->setTelephone(0102030405);
        $site=new Site();
        $site->setNom('Ecole ENI de Niort');
        $manager->persist($site);
        $participant->setSite($site);
        $manager->persist($participant);


        $site=new Site();
        $site->setNom('Ecole ENI de Nantes');
        $manager->persist($site);
        $site=new Site();
        $site->setNom('AFPA de La Roche sur Yon');
        $manager->persist($site);

        $participant = new Participant();
        $participant->setNom('MARTIN');
        $participant->setPrenom('Gaetan');
        $participant->setPseudo('Schak');
        $participant->setMotDePasse('test1234');
        $participant->setRole('USER_ADMIN');
        $participant->setMail('gaetan@hotmail.fr');
        $participant->setTelephone(0203040506);
        $participant->setSite($site);
        $manager->persist($participant);

        $participant = new Participant();
        $participant->setNom('GONCALVES DIAS');
        $participant->setPrenom('Daniel');
        $participant->setPseudo('Le brillant Dany');
        $participant->setMotDePasse('test1234');
        $participant->setRole('USER_USER');
        $participant->setMail('daniel@hotmail.fr');
        $participant->setTelephone(0304050607);
        $participant->setSite($site);
        $manager->persist($participant);


        $participant = new Participant();
        $participant->setNom('COLLENOT');
        $participant->setPrenom('Charles');
        $participant->setPseudo('Gloxy');
        $participant->setMotDePasse('test1234');
        $participant->setRole('USER_ADMIN');
        $participant->setMail('charles@hotmail.fr');
        $participant->setSite($site);
        $manager->persist($participant);

        $sortie = new Sortie();
        $sortie->setSite($site);
        $sortie->setNom('Portes Ouvertes');
        $sortie->setDuree(90);
        $sortie->setDateLimiteInscription(new \DateTime("2020-05-08 21:00:00"));
        $sortie->setDateHeureDebut(new \DateTime("2020-05-10 10:00:00"));
        $sortie->setNbIncriptionsMax(10);
        $sortie->setSortiesOrganisees($participant);
        $sortie->setEtat($etat);
        $sortie->setInfosSortie('Journée de présentation de l\'école avec des anciens élèves');
        $manager->persist($sortie);




        $manager->flush();
    }
}
