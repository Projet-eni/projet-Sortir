-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 07 mai 2020 à 15:17
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `sortie`
--

-- --------------------------------------------------------

--
-- Structure de la table `etat`
--

DROP TABLE IF EXISTS `etat`;
CREATE TABLE IF NOT EXISTS `etat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `etat`
--

INSERT INTO `etat` (`id`, `libelle`) VALUES
(1, 'Créée'),
(2, 'Clôturée'),
(3, 'Activité en cours'),
(4, 'Passée'),
(5, 'Annulée'),
(6, 'Ouverte'),
(7, 'archivée');

-- --------------------------------------------------------

--
-- Structure de la table `lieu`
--

DROP TABLE IF EXISTS `lieu`;
CREATE TABLE IF NOT EXISTS `lieu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ville_id` int(11) DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2F577D59A73F0036` (`ville_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `lieu`
--

INSERT INTO `lieu` (`id`, `ville_id`, `nom`, `rue`, `latitude`, `longitude`) VALUES
(1, 2, 'ENI Ecole', '19 Avenue Léo Lagrange', 46.3160155, -0.4713764),
(2, 3, 'ENI Ecole', '3 rue Michael Faraday', 47.2258547, -1.6200333),
(3, 4, 'ici', 'du bon temps', -89.734743, 132.890625);

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `participant`
--

DROP TABLE IF EXISTS `participant`;
CREATE TABLE IF NOT EXISTS `participant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mot_de_passe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pseudo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` int(11) DEFAULT NULL,
  `mail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `actif` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D79F6B11F6BD1646` (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `participant`
--

INSERT INTO `participant` (`id`, `site_id`, `nom`, `mot_de_passe`, `prenom`, `pseudo`, `telephone`, `mail`, `role`, `image`, `updated_at`, `password_requested_at`, `token`, `actif`) VALUES
(1, 1, 'LOESEL', '$2y$13$bYmi8g9Y3w91IoyR2uDTpuLOmDtkJlxb3q34UHgzWLODXanWIHJLK', 'Pierre', 'Skullpie', 17314053, 'pierre@hotmail.fr', '[\"ROLE_USER\"]', NULL, NULL, NULL, NULL, 1),
(2, 3, 'MARTIN', '$2y$13$bYmi8g9Y3w91IoyR2uDTpuLOmDtkJlxb3q34UHgzWLODXanWIHJLK', 'Gaetan', 'Schak', 34357574, 'gaetan@hotmail.fr', '[\"ROLE_USER\"]', NULL, NULL, NULL, NULL, 1),
(3, 3, 'GONCALVES DIAS', '$2y$13$VxKRirV.xq.kkHhi9q.1w.y9A1Y5mwTZHypvlINvfHMf7VXnJvjf6', 'Daniel', 'Dany', 102030405, 'dany98@hotmail.fr', '[\"ROLE_ADMIN\"]', 'photodaniel-5eb2d0c9b52b2488092533.png', '2020-05-06 16:59:21', '2020-05-07 09:24:14', '9V1EDJ42xH9u8GcKrfwFfne4WRAkIO1kMgFrcOfJ37k', 1),
(4, 3, 'COLLENOT', '$2y$13$bYmi8g9Y3w91IoyR2uDTpuLOmDtkJlxb3q34UHgzWLODXanWIHJLK', 'Charles', 'Gloxy', NULL, 'charles@hotmail.fr', '[\"ROLE_USER\"]', NULL, NULL, NULL, NULL, 1),
(5, 1, 'tata', '$2y$13$T4ys4ex26Ap5ZfM.vAUZDujq/Xjmy9c9pCgRhkX9CPMs/baycZfIy', 'toto', 'superToto', 102030405, 'toto@hotmail.fr', '[\"ROLE_USER\"]', NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `participant_sortie`
--

DROP TABLE IF EXISTS `participant_sortie`;
CREATE TABLE IF NOT EXISTS `participant_sortie` (
  `participant_id` int(11) NOT NULL,
  `sortie_id` int(11) NOT NULL,
  PRIMARY KEY (`participant_id`,`sortie_id`),
  KEY `IDX_8E436D739D1C3019` (`participant_id`),
  KEY `IDX_8E436D73CC72D953` (`sortie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `participant_sortie`
--

INSERT INTO `participant_sortie` (`participant_id`, `sortie_id`) VALUES
(3, 1),
(3, 5);

-- --------------------------------------------------------

--
-- Structure de la table `site`
--

DROP TABLE IF EXISTS `site`;
CREATE TABLE IF NOT EXISTS `site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `site`
--

INSERT INTO `site` (`id`, `nom`) VALUES
(1, 'Ecole ENI de Niort'),
(2, 'Ecole ENI de Nantes'),
(3, 'AFPA de La Roche sur Yon');

-- --------------------------------------------------------

--
-- Structure de la table `sortie`
--

DROP TABLE IF EXISTS `sortie`;
CREATE TABLE IF NOT EXISTS `sortie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) DEFAULT NULL,
  `sorties_organisees_id` int(11) DEFAULT NULL,
  `lieu_id` int(11) DEFAULT NULL,
  `etat_id` int(11) DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_heure_debut` date NOT NULL,
  `duree` int(11) NOT NULL,
  `date_limite_inscription` date NOT NULL,
  `nb_inscriptions_max` int(11) NOT NULL,
  `infos_sortie` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3C3FD3F2F6BD1646` (`site_id`),
  KEY `IDX_3C3FD3F271DFB785` (`sorties_organisees_id`),
  KEY `IDX_3C3FD3F26AB213CC` (`lieu_id`),
  KEY `IDX_3C3FD3F2D5E86FF` (`etat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sortie`
--

INSERT INTO `sortie` (`id`, `site_id`, `sorties_organisees_id`, `lieu_id`, `etat_id`, `nom`, `date_heure_debut`, `duree`, `date_limite_inscription`, `nb_inscriptions_max`, `infos_sortie`) VALUES
(1, 3, 4, 1, 6, 'Portes Ouvertes', '2020-05-11', 90, '2020-05-08', 10, 'Journée de présentation de l\'école avec des anciens élèves'),
(2, 2, 3, 1, 2, 'Sortie à cloturer(2)', '2020-11-15', 1, '2020-05-05', 1, 'date passé d\'un jour'),
(3, 3, 3, 3, 1, 'Sortie en tête à tête', '2023-01-15', 1, '2023-01-15', 1, 'avec moi même'),
(5, 2, 1, 1, 6, 'picnic a la plage', '2020-06-19', 1, '2020-06-18', 19, 'Et faire des châteaux de sables.'),
(6, 3, 3, 3, 3, 'sortie activité en cours', '2020-05-06', 2, '2020-05-05', 2, 'a partir de la date_heure_debut'),
(7, 3, 3, 3, 4, 'passage etat passé(4)', '2020-05-02', 2, '2020-05-01', 2, 'après la date de date_heure_debut + duréé+1jour'),
(8, 2, 3, 3, 6, 'aller voir le soleil', '2020-07-25', 2, '2020-07-16', 2, 'sur la plage'),
(9, 3, 3, 2, 4, 'picnic au parc', '2019-03-30', 2, '2019-03-25', 3, 'pour faire la fête!!'),
(10, 1, 3, 2, 6, 'picnic au parc', '2021-03-30', 2, '2021-03-25', 3, 'pour faire la fête!!');

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

DROP TABLE IF EXISTS `ville`;
CREATE TABLE IF NOT EXISTS `ville` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_postal` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ville`
--

INSERT INTO `ville` (`id`, `nom`, `code_postal`) VALUES
(1, 'La Roche sur Yon', 85000),
(2, 'Niort', 79000),
(3, 'Saint-Herblain', 44800),
(4, 'LEGE', 44650);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `lieu`
--
ALTER TABLE `lieu`
  ADD CONSTRAINT `FK_2F577D59A73F0036` FOREIGN KEY (`ville_id`) REFERENCES `ville` (`id`);

--
-- Contraintes pour la table `participant`
--
ALTER TABLE `participant`
  ADD CONSTRAINT `FK_D79F6B11F6BD1646` FOREIGN KEY (`site_id`) REFERENCES `site` (`id`);

--
-- Contraintes pour la table `participant_sortie`
--
ALTER TABLE `participant_sortie`
  ADD CONSTRAINT `FK_8E436D739D1C3019` FOREIGN KEY (`participant_id`) REFERENCES `participant` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_8E436D73CC72D953` FOREIGN KEY (`sortie_id`) REFERENCES `sortie` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sortie`
--
ALTER TABLE `sortie`
  ADD CONSTRAINT `FK_3C3FD3F26AB213CC` FOREIGN KEY (`lieu_id`) REFERENCES `lieu` (`id`),
  ADD CONSTRAINT `FK_3C3FD3F271DFB785` FOREIGN KEY (`sorties_organisees_id`) REFERENCES `participant` (`id`),
  ADD CONSTRAINT `FK_3C3FD3F2D5E86FF` FOREIGN KEY (`etat_id`) REFERENCES `etat` (`id`),
  ADD CONSTRAINT `FK_3C3FD3F2F6BD1646` FOREIGN KEY (`site_id`) REFERENCES `site` (`id`);

DELIMITER $$
--
-- Évènements
--
DROP EVENT `Archiver les Sorties = cloturé`$$
CREATE DEFINER=`root`@`localhost` EVENT `Archiver les Sorties = cloturé` ON SCHEDULE EVERY 1 DAY STARTS '2020-05-06 00:00:00' ON COMPLETION NOT PRESERVE ENABLE COMMENT 'Permet de gérer les etat des sorties.' DO UPDATE sortie SET etat_id = 2 WHERE date_limite_inscription < CURRENT_DATE && etat_id != 2$$

DROP EVENT `Archiver les Sorties = activité en cours`$$
CREATE DEFINER=`root`@`localhost` EVENT `Archiver les Sorties = activité en cours` ON SCHEDULE EVERY 1 DAY STARTS '2020-05-06 00:00:00' ON COMPLETION NOT PRESERVE ENABLE COMMENT 'Permet de gérer les etat des sorties.' DO UPDATE sortie SET etat_id = 3 WHERE  CURRENT_DATE =date_heure_debut && etat_id != 3$$

DROP EVENT `Archiver les Sorties = passée`$$
CREATE DEFINER=`root`@`localhost` EVENT `Archiver les Sorties = passée` ON SCHEDULE EVERY 1 DAY STARTS '2020-05-06 00:00:00' ON COMPLETION NOT PRESERVE ENABLE COMMENT 'Permet de gérer les etat des sorties.' DO UPDATE sortie SET etat_id = 4 WHERE  CURRENT_DATE >= ADDDATE(`date_heure_debut`, 1)&& etat_id != 4$$

DROP EVENT `Archiver les Sorties = archivée`$$
CREATE DEFINER=`root`@`localhost` EVENT `Archiver les Sorties = archivée` ON SCHEDULE EVERY 1 DAY STARTS '2020-05-06 00:00:00' ON COMPLETION NOT PRESERVE ENABLE COMMENT 'Permet de gérer les etat des sorties.' DO UPDATE sortie SET etat_id = 7 WHERE  CURRENT_DATE >= ADDDATE(`date_heure_debut`, 31) && etat_id != 7$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
