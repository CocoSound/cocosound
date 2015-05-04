-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 04 Mai 2015 à 10:31
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `cocosound`
--

-- --------------------------------------------------------

--
-- Structure de la table `composer`
--

CREATE TABLE IF NOT EXISTS `composer` (
  `Numero_Playlist` int(11) NOT NULL AUTO_INCREMENT,
  `Numero_Musique` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Numero_Playlist`,`Numero_Musique`),
  KEY `FK_Composer_Numero_Musique` (`Numero_Musique`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `musique`
--

CREATE TABLE IF NOT EXISTS `musique` (
  `Numero_Musique` int(11) NOT NULL AUTO_INCREMENT,
  `Artiste` varchar(50) DEFAULT NULL,
  `Titre` varchar(50) DEFAULT NULL,
  `Genre` varchar(20) DEFAULT NULL,
  `Chemin_Musique` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Numero_Musique`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Structure de la table `playlist`
--

CREATE TABLE IF NOT EXISTS `playlist` (
  `Numero_Playlist` int(11) NOT NULL AUTO_INCREMENT,
  `Identifiant` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Numero_Playlist`),
  KEY `FK_Playlist_Identifiant` (`Identifiant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `uploader`
--

CREATE TABLE IF NOT EXISTS `uploader` (
  `Artiste` varchar(50) NOT NULL DEFAULT '',
  `Titre` varchar(50) NOT NULL DEFAULT '',
  `Identifiant` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`Identifiant`,`Artiste`,`Titre`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `Identifiant` varchar(50) NOT NULL DEFAULT '',
  `Mot_de_Passe` varchar(50) DEFAULT NULL,
  `Date_Inscription` date DEFAULT NULL,
  `Role` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Identifiant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`Identifiant`, `Mot_de_Passe`, `Date_Inscription`, `Role`) VALUES
('Ezerah', '12369874qb', '2015-05-04', 'user');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `composer`
--
ALTER TABLE `composer`
  ADD CONSTRAINT `FK_Composer_Numero_Musique` FOREIGN KEY (`Numero_Musique`) REFERENCES `musique` (`Numero_Musique`),
  ADD CONSTRAINT `FK_Composer_Numero_Playlist` FOREIGN KEY (`Numero_Playlist`) REFERENCES `playlist` (`Numero_Playlist`);

--
-- Contraintes pour la table `playlist`
--
ALTER TABLE `playlist`
  ADD CONSTRAINT `FK_Playlist_Identifiant` FOREIGN KEY (`Identifiant`) REFERENCES `utilisateur` (`Identifiant`);

--
-- Contraintes pour la table `uploader`
--
ALTER TABLE `uploader`
  ADD CONSTRAINT `FK_Uploader_Identifiant` FOREIGN KEY (`Identifiant`) REFERENCES `utilisateur` (`Identifiant`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
