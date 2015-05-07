-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2015 at 03:37 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cocosound`
--

-- --------------------------------------------------------

--
-- Table structure for table `composer`
--

CREATE TABLE IF NOT EXISTS `composer` (
  `Numero_Playlist` int(11) NOT NULL AUTO_INCREMENT,
  `Numero_Musique` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Numero_Playlist`,`Numero_Musique`),
  KEY `FK_Composer_Numero_Musique` (`Numero_Musique`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `musique`
--

CREATE TABLE IF NOT EXISTS `musique` (
  `Numero_Musique` int(11) NOT NULL AUTO_INCREMENT,
  `Artiste` varchar(50) DEFAULT NULL,
  `Titre` varchar(50) DEFAULT NULL,
  `Genre` varchar(20) DEFAULT NULL,
  `Chemin_Musique` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Numero_Musique`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `musique`
--

INSERT INTO `musique` (`Numero_Musique`, `Artiste`, `Titre`, `Genre`, `Chemin_Musique`) VALUES
(2, 'swagman', 'lol', 'merde', './upload/Kalimba.mp3');

-- --------------------------------------------------------

--
-- Table structure for table `musiques_playlist`
--

CREATE TABLE IF NOT EXISTS `musiques_playlist` (
  `id_musique` int(11) NOT NULL,
  `id_playlist` int(11) NOT NULL,
  PRIMARY KEY (`id_musique`,`id_playlist`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `musiques_playlist`
--

INSERT INTO `musiques_playlist` (`id_musique`, `id_playlist`) VALUES
(2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `playlist`
--

CREATE TABLE IF NOT EXISTS `playlist` (
  `Numero_Playlist` int(11) NOT NULL AUTO_INCREMENT,
  `nom_playlist` varchar(100) NOT NULL,
  `Identifiant` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Numero_Playlist`),
  KEY `FK_Playlist_Identifiant` (`Identifiant`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `playlist`
--

INSERT INTO `playlist` (`Numero_Playlist`, `nom_playlist`, `Identifiant`) VALUES
(4, 'La Playlist de test', 'Gildas'),
(5, 'Encore une autre de test', 'Gildas'),
(6, 'et puis une autre encore', 'Gildas');

-- --------------------------------------------------------

--
-- Table structure for table `uploader`
--

CREATE TABLE IF NOT EXISTS `uploader` (
  `Identifiant` varchar(50) NOT NULL DEFAULT '',
  `Numero_Musique` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Identifiant`,`Numero_Musique`),
  KEY `FK_Uploader_Numero_Musique` (`Numero_Musique`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uploader`
--

INSERT INTO `uploader` (`Identifiant`, `Numero_Musique`) VALUES
('Gildas', 2);

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `Identifiant` varchar(50) NOT NULL DEFAULT '',
  `Mot_de_Passe` varchar(50) DEFAULT NULL,
  `Date_Inscription` date DEFAULT NULL,
  `Role` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Identifiant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`Identifiant`, `Mot_de_Passe`, `Date_Inscription`, `Role`) VALUES
('Ezerah', '12369874qb', '2015-05-04', 'user'),
('Gildas', 'qwerty', '2015-05-07', 'user');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `composer`
--
ALTER TABLE `composer`
  ADD CONSTRAINT `FK_Composer_Numero_Musique` FOREIGN KEY (`Numero_Musique`) REFERENCES `musique` (`Numero_Musique`),
  ADD CONSTRAINT `FK_Composer_Numero_Playlist` FOREIGN KEY (`Numero_Playlist`) REFERENCES `playlist` (`Numero_Playlist`);

--
-- Constraints for table `playlist`
--
ALTER TABLE `playlist`
  ADD CONSTRAINT `FK_Playlist_Identifiant` FOREIGN KEY (`Identifiant`) REFERENCES `utilisateur` (`Identifiant`);

--
-- Constraints for table `uploader`
--
ALTER TABLE `uploader`
  ADD CONSTRAINT `FK_Uploader_Identifiant` FOREIGN KEY (`Identifiant`) REFERENCES `utilisateur` (`Identifiant`),
  ADD CONSTRAINT `FK_Uploader_Numero_Musique` FOREIGN KEY (`Numero_Musique`) REFERENCES `musique` (`Numero_Musique`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
